<?php
require_once './app/trait/AuthTrait.php';
require_once './app/repositories/UserRepository.php';

class AuthService {
    use AuthTrait;

    public function login(string $email, string $password): bool {
        $userRepository = new UserRepository();

        $user = $userRepository->findByEmail($email);

        if($user !== null && $this->verify($password,$user->getPassword()))
        {
            if(session_status() == PHP_SESSION_NONE)
                session_start();
                $_SESSION['user'] = serialize($user);
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_role'] = $user->getRole(); // Ajouter le rôle dans la session
            return true;
        }
        return false;
    }
    
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