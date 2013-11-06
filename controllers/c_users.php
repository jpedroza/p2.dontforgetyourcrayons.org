<?php
class users_controller extends base_controller {

        /*-------------------------------------------------------------------------------------------------
        
        -------------------------------------------------------------------------------------------------*/
    public function __construct() {
    
            # Make sure the base controller construct gets called
                parent::__construct();
    }


        /*-------------------------------------------------------------------------------------------------
        Display a form so users can sign up        
        -------------------------------------------------------------------------------------------------*/
    public function signup() {
       
       # Set up the view
       $this->template->content = View::instance('v_users_signup');
       
       # Render the view
       echo $this->template;
       
    }
    
    
    /*-------------------------------------------------------------------------------------------------
Process the sign up form
-------------------------------------------------------------------------------------------------*/
    public function p_signup() {
         
		 
		 # Attach on the timestamp using the library
		 $_POST['created'] = Time::now();
		 
		 # Using Sha1l apply the one-way hash to a salt in the config.php
		 $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		 
		 # Create a hashed token
         $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
		 
		 
		 # Insert the new user
         DB::instance(DB_NAME)->insert_row('users', $_POST);
		 
		 # Send them to the login page
         Router::redirect('/users/login');
		 
        
    }


        /*-------------------------------------------------------------------------------------------------
        Display a form so users can login
        -------------------------------------------------------------------------------------------------*/
    public function login() {
    
            $this->template->content = View::instance('v_users_login');         
            echo $this->template;
       
    }
    
    
    /*-------------------------------------------------------------------------------------------------
Process the login form
-------------------------------------------------------------------------------------------------*/
    public function p_login() {
                 
                 # Hash the password they entered so we can compare it with the ones in the database
                $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
                
                # Set up the query to see if there's a matching email/password in the DB
                $q =
                        'SELECT token
                        FROM users
                        WHERE email = "'.$_POST['email'].'"
                        AND password = "'.$_POST['password'].'"';
                
                //echo $q;        
                
                # If there was, this will return the token        
                $token = DB::instance(DB_NAME)->select_field($q);
                
                # Success
                if($token) {
                
                        # Don't echo anything to the page before setting this cookie!
                        setcookie('token',$token, strtotime('+1 year'), '/');
                        
                        # Send them to the homepage
                        Router::redirect('/');
                }
                # Fail
                else {
                        echo "Login failed! <a href='/users/login'>Try again?</a>";
                }
        
    }


        /*-------------------------------------------------------------------------------------------------
        No view needed here, they just goto /users/logout, it logs them out and sends them
        back to the homepage.        
        -------------------------------------------------------------------------------------------------*/
    public function logout() {
       
       # Generate a new token they'll use next time they login
       $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
       
       # Update their row in the DB with the new token
       $data = Array(
               'token' => $new_token
       );
       DB::instance(DB_NAME)->update('users',$data, 'WHERE user_id ='. $this->user->user_id);
       
       # Delete their old token cookie by expiring it
       setcookie('token', '', strtotime('-1 year'), '/');
       
       # Send them back to the homepage
       Router::redirect('/');
       
    }

        /*-------------------------------------------------------------------------------------------------
        
        -------------------------------------------------------------------------------------------------*/
    public function profile($user_name = NULL) {
                
                # Only logged in users are allowed...
                if(!$this->user) {
                        die('Members only. Please Log In or sign up for an account. <a href="/users/login">Login</a>');
                }
                
                # Set up the View
                $this->template->content = View::instance('v_users_profile');
                $this->template->title = "Profile";
                                
                # Pass the data to the View
                $this->template->content->user_name = $user_name;
                
                # Display the view
                echo $this->template;
                                
    }

	public function edit_profile($status = NULL) {

                #If there is no legitimate cookie, route to the homepage
                if(!$this->user) {
                        Router::redirect('/');
                        return false;//status
                }

                #Call the view to edit the picture in the profile
                $this->template->content = View::instance('v_users_edit_profile');
                $this->template->title = 'Stay In Text!';

                # Render the view
                echo $this->template;
	}
	
	public function p_edit_profile() {

                # If "Delete photo" box was checked and no new image was submitted
                # add placeholder images to $_POST array to overwrite existing image
                if ((array_key_exists('delete_photo', $_POST)) && ($_FILES['profile_image']['name'] == "")) {
                        $_POST['profile_image'] = "placeholder.png";
                        $_POST['thumb_image'] = "placeholder_thumb.png";
                        $_POST['alt_text'] = "Placeholder profile image";
                }
                
                # If an image was submitted, upload to server,
                # resize and save profile (250x250) and thumb (75x75) versions,
                # and add the filenames to the $_POST array
                if ($_FILES['profile_image']['name'] != "") {
                
                        # Upload submitted image to server
                        $profile_image = Upload::upload($_FILES, "/uploads/", array("jpg", "jpeg", "gif", "png", "JPG", "JPEG", "GIF", "PNG"), "profile_image_".$this->user->user_id);
                        
                        # Instantiate new image object using uploaded file
                        $imgObj = new Image(APP_PATH."uploads/".$profile_image);
                        
                        # Resize and save profile version of image
                         $imgObj->resize(250,250,"crop");
                        $imgObj->save_image(APP_PATH."uploads/".$profile_image, 100);
                        
                        # Resize and save thumbnail version of image
                        $file_parts = pathinfo($profile_image);
                        $thumb_image = "thumb_image_".$this->user->user_id.".".$file_parts['extension'];
                        $imgObj->resize(75,75,"crop");
                        $imgObj->save_image(APP_PATH."uploads/".$thumb_image, 100);

                        # Add image filenames and alt text to POST array
                        $_POST['profile_image'] = $profile_image;
                        $_POST['thumb_image'] = $thumb_image;
                        $_POST['alt_text'] = "Profile image for ".$this->user->first_name;

                }
                
                # (If "Delete photo" is unchecked and no new image was submitted,
                # do nothing -- image fields in DB remains as-is)

                # Remove "Delete photo" checkbox from $_POST array if it exists
                if (array_key_exists('delete_photo', $_POST)) {
                        unset($_POST['delete_photo']);
                }
                
                # Update DB with new profile information (including empty fields)
                DB::instance(DB_NAME)->update("users", $_POST, "WHERE token = '".$this->user->token."'");                
    }
	
} # end of the class
?>