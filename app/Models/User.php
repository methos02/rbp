<?php
namespace App\Models;

use Exception;

class User extends Model {

    protected static string $table = "users";

    protected string $id;
    protected string $lastname;
    protected string $firstname;
    protected string $email;
    protected string $password;
    protected string $token;
    protected string $roles;
    protected ?int $section_id;

    /**
     * @throws Exception
     * @noinspection PhpUnused
     */
    public function default_properties():array {
        return ['token' => bin2hex(random_bytes(16))];

    }
    /** @noinspection PhpUnused */
    public function setPassword(string $password):self {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }
    /** @noinspection PhpUnused */
    public function setLastname(string $lastname):self {
        $this->lastname = strtoupper($lastname);
        return $this;
    }
    /** @noinspection PhpUnused */
    public function setFirstname(string $firstname):self {
        $this->firstname = ucfirst($firstname);
        return $this;
    }
    /** @noinspection PhpUnused */
    public function getFullName():string {
        return $this->lastname. " " .$this->firstname;
    }
}
