<?php
// déclaration d'une classe Auteur

class Media {
  public $id;
  public $nom;
  public $chemin;
  public $datatype;

  static function readAll() {
    // définition de la requête SQL
    $sql= 'SELECT * FROM medias';

    // connexion
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // exécution de la requête
    $query->execute();

    // récupération de toutes les lignes sous forme d'objets
    $tableau = $query->fetchAll(PDO::FETCH_CLASS,'Media');

    // retourne le tableau d'objets
    return $tableau;
  }

  function chargePOST()
  {
    //On verifie et attribut les elements recupéré en POST
    if (isset($_POST['id'])) {
      $this->id = $_POST['id'];
    } else {
      $this->id = 0;
    }

    if (isset($_POST['nom'])) {
      $this->nom = $_FILES['media']['name'];
    } else {
      $this->nom = 'sans_nom_'.$this->id;
    }

    if (isset($_POST['datatype'])) {
      $this->datatype = $_POST['datatype'];
    } else {
      $this->datatype = '';
    }

  }

  static function readOne($id)
  {
    $sql= 'SELECT e.*, m.nom AS media_nom, m.datatype AS media_datatype FROM elements e LEFT JOIN medias m ON e.id_media = m.id WHERE e.id = :id;';

    $pdo = connexion();
 
    // préparation de la requête
    $query = $pdo->prepare($sql);
    
    // on donne une valeur au paramètre correspondant à la clé
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    
    // exécution de la requête
    $query->execute();

    // récupération de l'unique ligne
    $objet = $query->fetchObject('Media');

    // retourne l'objet contenant résultat
    return $objet;
  }

  function upload()
  {
    $currentDirectory = getcwd();
    $uploadDirectory = "/uploads/";


    $fileName = $_FILES['media']['name'];
    $fileSize = $_FILES['media']['size'];
    $fileTmpName  = $_FILES['media']['tmp_name'];
    $fileType = $_FILES['media']['type'];

    $uploadPath = $currentDirectory . $uploadDirectory . $this->datatype . '/' .basename($this->nom); 

    $errors = []; // Store errors here

    if (isset($_POST['create'])) {
      
      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
          echo "The file " . basename($fileName) . " has been uploaded";
        } else {
          echo "An error occurred. Please contact the administrator.";
        }
      } else {
        foreach ($errors as $error) {
          echo $error . "These are the errors" . "\n";
        }
      }
    }


    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'INSERT INTO medias (nom, chemin, datatype) VALUES (:nom, :chemin, :datatype);';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on lie le paramètre :id à la variable $id reçue
    $query->bindValue(':nom', $this->nom, PDO::PARAM_STR);
    $query->bindValue(':chemin', $uploadPath, PDO::PARAM_STR);
    $query->bindValue(':datatype', $this->datatype, PDO::PARAM_STR);

    // exécution de la requête
    $query->execute();


    $this->id = $pdo->lastInsertId();

  }

  static function delete($id)
  {
    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'SELECT * FROM medias WHERE id = :id;';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on lie le paramètre :id à la variable $id reçue
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();

    $tableau = $query->fetchAll(PDO::FETCH_CLASS,'Media');

    // retourne le tableau d'objets
    $mediaName = get_object_vars($tableau[0])['nom'];
    $mediaDatatype = get_object_vars($tableau[0])['datatype'];
    unlink('./uploads/'.$mediaDatatype.'/'.$mediaName);

    $sql = 'DELETE FROM medias WHERE id = :id;';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on lie le paramètre :id à la variable $id reçue
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();
  }
}
?>
