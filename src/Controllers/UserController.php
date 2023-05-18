<?php declare(strict_types=1);

namespace Tm\Admin\Controllers;

use PDO;
use Delight\Auth\Auth;

class UserController {

    private $db, $auth, $templates;

    function __construct(PDO $pdo, Auth $auth, Engine $templates) {
        $this->db = $pdo;
        $this->auth = $auth;
        $this->templates = $templates;
    }

    public function users_form_view(): void 
    {
        if ($this->auth->isLoggedIn()) {
            $this->templates->run('users');
        } else {
            $this->templates->run('login');
        }
    }   

    
}


