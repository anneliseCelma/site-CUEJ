<?php


class Famille {
  public $id;
  public $nom;

  static function readAll() {
    // définition de la requête SQL
    $sql= 'SELECT * FROM familles';

    // connexion
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // exécution de la requête
    $query->execute();

    // récupération de toutes les lignes sous forme d'objets
    $tableau = $query->fetchAll(PDO::FETCH_CLASS,'Famille');

    // retourne le tableau d'objets
    return $tableau;
  }

  // static function readLast4() {
  //   // définition de la requête SQL
  //   $sql= 'select * from articles ORDER BY date DESC LIMIT 4';

  //   // connexion
  //   $pdo = connexion();

  //   // préparation de la requête
  //   $query = $pdo->prepare($sql);

  //   // exécution de la requête
  //   $query->execute();

  //   // récupération de toutes les lignes sous forme d'objets
  //   $tableau = $query->fetchAll(PDO::FETCH_CLASS,'Article');

  //   // retourne le tableau d'objets
  //   return $tableau;
  // }

  static function readOne($id)
  {
    $sql= 'SELECT * FROM familles WHERE id = :id;';

    $pdo = connexion();
 
    // préparation de la requête
    $query = $pdo->prepare($sql);
    
    // on donne une valeur au paramètre correspondant à la clé
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    
    // exécution de la requête
    $query->execute();

    // récupération de l'unique ligne
    $objet = $query->fetchObject('Famille');
 
    // retourne l'objet contenant résultat
    return $objet;
  }

  // static function readElements($id)
  // {
  //   $sql= 'SELECT * FROM elements WHERE id_article = :id ORDER BY ordre;';

  //   $pdo = connexion();

  //   // préparation de la requête
  //   $query = $pdo->prepare($sql);
    
  //   // on donne une valeur au paramètre correspondant à la clé
  //   $query->bindValue(':id', $id, PDO::PARAM_INT);
    
  //   // exécution de la requête
  //   $query->execute();

  //   // récupération de l'unique ligne
  //   $tableau = $query->fetchAll(PDO::FETCH_CLASS,'Element');
 
  //   // // var_dump($id);
  //   // retourne l'objet contenant résultat
  //   return $tableau;
  // }

  // function chargePOST() {
  //   //On verifie et attribut les elements recupéré en POST
  //   if (isset($_POST['id'])) {
  //     $this->id = $_POST['id'];
  //   } else {
  //     $this->id = 0;
  //   }

  //   if (isset($_POST['titre'])) {
  //     $this->titre = $_POST['titre'];
  //   } else {
  //     $this->titre = 'Sans titre';
  //   }

  //   if (isset($_POST['sousTitre'])) {
  //     $this->sousTitre = $_POST['sousTitre'];
  //   } else {
  //     $this->sousTitre = '';
  //   }

  //   if (isset($_POST['auteur'])) {
  //     $this->auteur = $_POST['auteur'];
  //   } else {
  //     $this->auteur = '';
  //   }
  // }

  // function create() {
  //   // On prepare la requete SQL selon les entrées de l'utilisateurs
  //   $sql = 'INSERT INTO articles (titre, sous_titre, auteur, date) VALUES (:titre, :sous_titre, :auteur, :date);';
 
  //   // connexion à la base de données
  //   $pdo = connexion();
 
  //   // préparation de la requête
  //   $query = $pdo->prepare($sql);
 
  //   // on donne une valeur aux paramètres à partir des attributs de l'objet courant
  //   $query->bindValue(':titre', $this->titre, PDO::PARAM_STR);
  //   $query->bindValue(':sous_titre', $this->sousTitre, PDO::PARAM_STR);
  //   $query->bindValue(':auteur', $this->auteur, PDO::PARAM_STR);
  //   $query->bindValue(':date', date("Y-m-d"), PDO::PARAM_STR);
 
  //   // Exécution de la requête
  //   $query->execute();
 
  //   $this->id = $pdo->lastInsertId();
  // }

  // static function delete($id) {
  //   // construction de la requête :nom, :prenom sont les valeurs à insérées
  //   $sql = 'DELETE FROM articles WHERE id = :id;';
 
  //   // connexion à la base de données
  //   $pdo = connexion();
 
  //   // préparation de la requête
  //   $query = $pdo->prepare($sql);
 
  //   // on lie le paramètre :id à la variable $id reçue
  //   $query->bindValue(':id', $id, PDO::PARAM_INT);
 
  //   // exécution de la requête
  //   $query->execute();
  // }

  // function update() {
  //   // construction de la requête :nom, :prenom sont les valeurs à insérées
  //   $sql = 'UPDATE articles SET titre = :titre, sous_titre = :sous_titre, auteur = :auteur, date = NOW() WHERE id = :id;';
  //   // connexion à la base de données
  //   $pdo = connexion();
 
  //   // préparation de la requête
  //   $query = $pdo->prepare($sql);
 
  //   // on donne une valeur aux paramètres à partir des attributs de l'objet courant
  //   $query->bindValue(':id', $this->id, PDO::PARAM_INT);
  //   $query->bindValue(':titre', $this->titre, PDO::PARAM_STR);
  //   $query->bindValue(':sous_titre', $this->sousTitre, PDO::PARAM_STR);
  //   $query->bindValue(':auteur', $this->auteur, PDO::PARAM_STR);
    
  //   //// var_dump('UPDATE articles SET titre = '.$this->titre.', sous_titre = '.$this->sousTitre.', auteur = '.$this->auteur.', date = NOW() WHERE id = '.$this->id.';');
  //   // exécution de la requête
  //   $query->execute();

  // }
}
?>
