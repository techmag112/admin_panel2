<?php declare(strict_types=1);

namespace Tm\Admin\Controllers;

use function Tamtamchik\SimpleFlash\flash;
use League\Plates\Engine;
use PDO;
use Delight\Auth\Auth;

class LoginController {

    private $db, $auth, $templates;

    function __construct(PDO $pdo, Auth $auth, Engine $templates) {
        $this->db = $pdo;
        $this->auth = $auth;
        $this->templates = $templates;
    }

    public function login_form_view(): void 
    {
        echo $this->templates->render('login');
    }

    public function reg_form_view(): void 
    {
        echo $this->templates->render('register');
    }

    public function login(): bool
    {
        if (!$auth->isLoggedIn()) {
            try {
                $auth->login($_POST['email'], $_POST['password']);
                echo $this->templates->render('users', ['message' => 'User is logged in', 'type' => 'success']);
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                echo $this->templates->render('login', ['message' => 'Wrong email address', 'type' => 'error']);
                return false;
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                echo $this->templates->render('login', ['message' => 'Wrong password', 'type' => 'error']);
                return false;
            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
                echo $this->templates->render('login', ['message' => 'Email not verified', 'type' => 'error']);
                return false;
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                echo $this->templates->render('login', ['message' => 'Too many requests', 'type' => 'error']);
                return false;
            }
        }
        return true;
    }
   
    public function registration(): void 
    {
        try {
               // $userId = $auth->admin()->createUser($_POST['email'], $_POST['password'], '');
                 $userId = $this->auth->register($_POST['email'], $_POST['password'], '', function ($selector, $token) {
                     echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                     echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                     echo '  For SMS, consider using a third-party service and a compatible SDK';
                 });
                echo $this->templates->render('login', ['message' => 'We have signed up a new user with the ID ' . $userId, 'type' => 'success']);

            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                echo $this->templates->render('register', ['message' => 'Invalid email address', 'type' => 'error']);
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                echo $this->templates->render('register', ['message' => 'Invalid password', 'type' => 'error']);
            }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
                echo $this->templates->render('register', ['message' => 'User already exists', 'type' => 'error']);
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                echo $this->templates->render('register', ['message' => 'Too many requests', 'type' => 'error']);
            }

       

    }
}


