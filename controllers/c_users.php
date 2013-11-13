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
       $this->template->content = View::instance('v_users_signup');//will add the new fields as shown below
                                                                   //bio, location, timezone
       # Render the view //make sure to check the db for matching
       echo $this->template; //fields
       
    }
    
    
    /*-------------------------------------------------------------------------------------------------
Process the sign up form
-------------------------------------------------------------------------------------------------*/
    public function p_signup() {
        
                if((trim($_POST[first_name])=="") || (trim($_POST[last_name])=="") || (trim($_POST[timezone])=="") || (trim($_POST[location])=="") || (trim($_POST[aboutyou])=="") || (trim($_POST[password])=="") || (trim($_POST[email])=="") ){
                        # remove the blank field from the $_POST array
                        unset($_POST[email]);
                        unset($_POST[password]);
                        unset($_POST[first_name]);
                        unset($_POST[last_name]);
                        unset($_POST[timezone]);
                        unset($_POST[location]);
                        unset($_POST[aboutyou]);
                        
                        # Send them to the login page
                        Router::redirect('/users/signup');
                        
                } else {
                         # Attach on the timestamp using the library
                         $_POST['created'] = Time::now();
                        
                         # Using Sha1l apply the one-way hash to a salt in the config.php
                         $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
                        
                         # Create a hashed token
                         $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
                        
                         # Add a quick view to see what is inside the $_POST - what was passed back from the form v_users_signup
                        
                         # Insert the new user
                         # Insert function already cleans up user input read from a form
                         DB::instance(DB_NAME)->insert_row('users', $_POST);
						 
						# Prepare the email message 
						$emailbody = "<a href='http://p2.dontforgetyourcrayons.org/allsignedup.html'>Click Here To Confirm Your Sign-Up</a>";
			 
						# Email
						Email::send('mr.john.pedroza@gmail.com', 'notification@dontforgetyourcrayons.org', 'test', $emailbody, true, '');
                        
                         # Send them to the login page
                         Router::redirect('/users/login');
                }
        
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
                        
                                                # Get current time to stuff in a data array
                                                $tm = Time::now();
                                                $data = Array(
                                                        'last_login' => $tm
                                                );
                                                
                                                $token = "'" . $token ."'";
                                                
                                                # Update the time logged in
                                                DB::instance(DB_NAME)->update('users', $data, 'WHERE token ='. $token);
                                                
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
The profile method
-------------------------------------------------------------------------------------------------*/
    public function profile($user_name = NULL) { # maybe change $user_name
                
                # Only logged in users are allowed...
                if(!$this->user) {
                        die('Members only. Please Log In or sign up for an account. <a href="/users/login">Login</a>');
                }
                
                # Set up the View
                $this->template->content = View::instance('v_users_profile');
                
                                # Edited the title to be passed off to the webpage
                                $this->template->title = "Edit your profile below";
                                
                # Pass the data to the View
                $this->template->content->user_name = $user_name;
                
                # Display the view
                echo $this->template;
                                
    }
        /*-------------------------------------------------------------------------------------------------
This method processes the edits from the v_users_profile.php
-------------------------------------------------------------------------------------------------*/        
        public function p_editprofile($user_name = NULL) { # maybe change $user_name
                                # take all the contents of the $_POST and update the db
                                
                                # if fields are blank remove them from the $_POST Array
                                if((trim($_POST[first_name])=="") || (trim($_POST[last_name])=="") || (trim($_POST[timezone])=="") || (trim($_POST[location])=="") || (trim($_POST[aboutyou])=="") ){
                                        
                                        # remove the blank field from the $_POST array
                                        unset($_POST[first_name]);
                                        unset($_POST[last_name]);
                                        unset($_POST[timezone]);
                                        unset($_POST[location]);
                                        unset($_POST[aboutyou]);
                                        
                                        # Send them to the login page
                                        Router::redirect('/users/profile');
                                } else {
                                
                                        # Update modified time
                                        $_POST[modified] = Time::now();
                                
                                        # Commit changes to the database
                                        DB::instance(DB_NAME)->update('users',$_POST, 'WHERE user_id ='. $this->user->user_id);
                                        
                                        # Send them to the login page
                                        Router::redirect('/');
        }                        }
        
} # end of the class
?>