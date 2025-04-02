<?php

require_once './app/core/Repository.php';

class QuestionsFrequentesRepository {
    private $repository;

    public function __construct() {
        $this->repository = Repository::getInstance();
    }

    public function getAllQuestions() {
        try {
            $sql = "SELECT * FROM questionsFrequentes ORDER BY id";
            $stmt = $this->repository->getPDO()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}