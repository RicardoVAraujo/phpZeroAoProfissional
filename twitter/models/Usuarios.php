<?php

class Usuarios extends Model {

    public function isLogged() {
        if (isset($_SESSION['twlg']) && !empty($_SESSION['twlg'])) {
            return true;
        } else {
            return false;
        }
    }

    public function usuarioExiste($email) {
        $sql = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email);
        $sql->execute();

        return $sql->rowCount() > 0;
    }

    public function inserirUsuario($nome, $email, $senha) {
        $sql = $this->db->prepare("INSERT INTO usuarios (nome, email, senha) "
                . "values(:nome, :email, :senha)");
        $sql->bindParam(':nome', $nome);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':senha', $senha);
        $sql->execute();

        $id = $this->db->lastInsertId();
        return $id;
    }

    public function fazerLogin($email, $senha) {
        $sql = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $sql->bindParam(':email', $email);
        $sql->bindParam(':senha', $senha);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $_SESSION['twlg'] = $sql['id'];
            return true;
        } else {
            return false;
        }
    }

}