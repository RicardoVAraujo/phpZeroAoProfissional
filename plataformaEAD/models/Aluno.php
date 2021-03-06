<?php

class Aluno extends Model {

    private $info;

    public function isLogged() {
        if (isset($_SESSION['lgaluno']) && !empty($_SESSION['lgaluno'])) {
            return true;
        }
        return false;
    }

    public function fazerLogin($email, $senha) {
        $sql = "SELECT * FROM alunos WHERE email = :email AND senha = :senha";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();

            $_SESSION['lgaluno'] = $row['id'];
            return true;
        }
        return false;
    }

    public function setAluno($id) {
        $sql = "SELECT * FROM alunos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $this->info = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function isInscrito($id_curso) {
        $sql = "SELECT * FROM aluno_cursos WHERE id_aluno = :id_aluno AND id_curso = :id_curso";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_aluno', $this->info['id']);
        $stmt->bindValue(':id_curso', $id_curso);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getNome() {
        return $this->info['nome'];
    }

    public function getId() {
        return $this->info['id'];
    }

}
