<?php
// déclaration d'une classe Auteur

class Article
{
  public $id;
  public $nom;
  public $auteur;
  public $id_couleur;
  public $chapo;
  public $id_page;
  public $id_img;
  public $id_media;

  function __construct()
  {
    // conversion d'un attribut
    $this->id = intval($this->id);

    // remplace une valeur vide par autre chose
    if (empty($this->nom)) $this->nom = 'inconnu';

    // définit un attribut complémentaire (hors base de données)
    $this->attribut_complementaire = 'valeur hors base de données';
  }

  static function readAll()
  {
    // définition de la requête SQL
    $sql = 'select * from articles';

    // connexion
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // exécution de la requête
    $query->execute();

    // récupération de toutes les lignes sous forme d'objets
    $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Article');

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
    $sql = 'SELECT a.*, m.nom AS media_nom, m.datatype AS media_datatype FROM articles a LEFT JOIN medias m ON m.id = a.id_media WHERE a.id = :id;';

    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur au paramètre correspondant à la clé
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();

    // récupération de l'unique ligne
    $objet = $query->fetchObject('Article');

    // retourne l'objet contenant résultat
    return $objet;
  }

  static function readElements($id)
  {
    $sql = 'SELECT e.*, c.nom AS nom_classe, m.nom AS media_nom, m.datatype AS media_datatype FROM elements e LEFT JOIN classes c ON c.id = e.id_classe LEFT JOIN medias m ON m.id = e.id_media WHERE id_article = :id ORDER BY ordre;';

    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur au paramètre correspondant à la clé
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();

    // récupération de l'unique ligne
    $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Element');

    // retourne l'objet contenant résultat
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
      $this->nom = $_POST['nom'];
    } else {
      $this->nom = 'Sans titre';
    }

    if (isset($_POST['chapo'])) {
      $this->chapo = $_POST['chapo'];
    } else {
      $this->chapo = '';
    }

    if (isset($_POST['auteur'])) {
      $this->auteur = $_POST['auteur'];
    } else {
      $this->auteur = '';
    }

    if (isset($_POST['id_img'])) {
      $this->id_img = $_POST['id_img'];
    } else {
      $this->id_img = '';
    }

    if (isset($_POST['id_couleur'])) {
      $this->id_couleur = $_POST['id_couleur'];
    } else {
      $this->id_couleur = '';
    }

    if (isset($_POST['id_page'])) {
      $this->id_page = $_POST['id_page'];
    } else {
      $this->id_page = '';
    }

    if (isset($_POST['id_media'])) {
      $this->id_media = $_POST['id_media'];
    } else {
      $this->id_media = '';
    }
  }

  function create()
  {
    // On prepare la requete SQL selon les entrées de l'utilisateurs
    $sql = 'INSERT INTO articles (nom, chapo, auteur, id_couleur, id_page, id_media) VALUES (:nom, :chapo, :auteur, :id_couleur, :id_page, :id_media);';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur aux paramètres à partir des attributs de l'objet courant
    $query->bindValue(':nom', $this->nom, PDO::PARAM_STR);
    $query->bindValue(':chapo', $this->chapo, PDO::PARAM_STR);
    $query->bindValue(':auteur', $this->auteur, PDO::PARAM_STR);
    $query->bindValue(':id_couleur', $this->id_couleur, PDO::PARAM_INT);
    $query->bindValue(':id_page', $this->id_page, PDO::PARAM_INT);
    $query->bindValue(':id_media', $this->id_media, PDO::PARAM_INT);

    // // var_dump('INSERT INTO articles (nom, chapo, auteur, id_couleur, id_page) VALUES ('.$this->nom.', '.$this->chapo.', '.$this->auteur.', '.$this->id_couleur.', '.$this->id_page.');');

    // Exécution de la requête
    $query->execute();

    $this->id = $pdo->lastInsertId();
  }

  static function delete($id)
  {
    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'DELETE FROM articles WHERE id = :id;';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on lie le paramètre :id à la variable $id reçue
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();
  }

  function update()
  {
    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'UPDATE articles SET nom = :nom, chapo = :chapo, auteur = :auteur, id_couleur = :id_couleur WHERE id = :id';
    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur aux paramètres à partir des attributs de l'objet courant
    $query->bindValue(':id', $this->id, PDO::PARAM_INT);
    $query->bindValue(':nom', $this->nom, PDO::PARAM_STR);
    $query->bindValue(':chapo', $this->chapo, PDO::PARAM_STR);
    $query->bindValue(':auteur', $this->auteur, PDO::PARAM_STR);
    $query->bindValue(':id_couleur', $this->id_couleur, PDO::PARAM_INT);

    //// var_dump('UPDATE articles SET titre = '.$this->titre.', sous_titre = '.$this->sousTitre.', auteur = '.$this->auteur.', date = NOW() WHERE id = '.$this->id.';');
    // exécution de la requête
    $query->execute();
  }
}
