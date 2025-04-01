<?php
require_once './app/traits/AuthTrait.php';

class AuthService {
    use AuthTrait;
    
    public function getUser(): ?User {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    }

    public function setUser(User $user): void {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user'] = serialize($user);
    }

    public function getUserRole(): ?string {
        $user = $this->getUser();
        return $user ? $user->getRole() : null;
    }

    public function isLoggedIn(): bool {
        return $this->getUser() !== null;
    }

    public function hasRole(string $role): bool {
        $user = $this->getUser();
        return $user && $user->getRole() === $role;
    }

    public function logout(): void {
        session_destroy();
    }
}