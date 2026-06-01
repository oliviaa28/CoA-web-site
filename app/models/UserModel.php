<?php 

class UserModel {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAllUsers(){

      $sql = $this->pdo->prepare( 'SELECT  id_admin AS "id",
                                            nume AS "nume",
                                            email AS "email",
                                           judet AS "judet",
                                           creat_la AS "created"
                                    FROM ADMINISTRATORI ');

        $sql->execute();
        return $sql->fetchAll(); //returnam un array cu toate randuril e
    }

    public function createUser($data){

       //inainte de a salva parola o facem hash 
       $parolaHash = password_hash( $data['password'], PASSWORD_DEFAULT);

       $sql = $this->pdo->prepare("INSERT INTO ADMINISTRATORI  (nume, email, username, parola, judet) 
                                       VALUES (?, ?, ?, ?, ?)");

        $sql->execute([
            $data['nume'],
            $data['email'],
            $data['email'],     // username = email
            $parolaHash,
            $data['judet']
         ]);
       
        return true;
    }

 
    public function deleteUser($id){
        $sql = $this->pdo->prepare("DELETE FROM ADMINISTRATORI WHERE id_admin = :id");
        $sql->execute(['id' => $id]);
          return true;
    }

    public function updateUser($id, $data){

       if(!empty($data['password'])) { //daca s a reintrodus o parola noua
          $parolaHash = password_hash($data ['password'], PASSWORD_DEFAULT);
          
           $sql = $this->pdo->prepare("UPDATE ADMINISTRATORI SET nume =?, email=?, judet =?, parola =? 
                                            WHERE id_admin = ?");
        $sql->execute([
            $data['nume'], $data['email'], $data['judet'],
             $parolaHash, $id
        ]);

       }else{ 
         $sql =$this->pdo->prepare("UPDATE ADMINISTRATORI SET nume = ?, email =?, judet =? 
                                            WHERE id_admin = ?");
        $sql->execute([
            $data['nume'], $data['email'],
             $data['judet'], $id
              ]);

       }
        return true;
    }


}

?>