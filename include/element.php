<?php
// déclaration d'une classe Auteur

class Element
{
  public $id;
  public $id_article;
  public $balise;
  public $contenu;
  public $href;
  public $ordre;
  public $id_classe;
  public $id_media;

  function __construct()
  {
    // conversion d'un attribut
    $this->id = intval($this->id);

    // remplace une valeur vide par autre chose
    // if (empty($this->nom)) $this->nom = 'inconnu';

    // définit un attribut complémentaire (hors base de données)
    $this->attribut_complementaire = 'valeur hors base de données';
  }

  static function readAll()
  {
    // définition de la requête SQL
    $sql = 'SELECT * FROM elements ORDER BY ordre;';

    // connexion
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // exécution de la requête
    $query->execute();

    // récupération de toutes les lignes sous forme d'objets
    $tableau = $query->fetchAll(PDO::FETCH_CLASS, 'Element');

    // retourne le tableau d'objets
    return $tableau;
  }

  static function readOne($id)
  {
    $sql = 'SELECT * FROM elements WHERE id = :id;';

    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur au paramètre correspondant à la clé
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();

    // récupération de l'unique ligne
    $objet = $query->fetchObject('Element');

    // retourne l'objet contenant résultat
    return $objet;
  }


  function chargePOST()
  {
    //On verifie et attribut les elements recupéré en POST
    if (isset($_POST['id'])) {
      $this->id = $_POST['id'];
    } else {
      $this->id = 0;
    }

    if (isset($_POST['id_article'])) {
      $this->id_article = $_POST['id_article'];
    } else {
      $this->id_article = null;
    }

    if (isset($_POST['balise'])) {
      $this->balise = $_POST['balise'];
    } else {
      $this->balise = 'p';
    }

    if (isset($_POST['contenu'])) {
      $this->contenu = $_POST['contenu'];
    } else {
      $this->contenu = '';
    }

    if (isset($_POST['href'])) {
      $this->href = $_POST['href'];
    } else {
      $this->href = '';
    }

    if (isset($_POST['id_classe']) && $_POST['id_classe'] != 0) {
      $this->id_classe = $_POST['id_classe'];
    } else {
      $this->id_classe = null;
    }

    if (isset($_POST['id_media']) && $_POST['id_classe'] != 0) {
      $this->id_media = $_POST['id_media'];
    } else {
      $this->id_media = null;
    }
  }
  

  function create()
  {
    // On prepare la requete SQL selon les entrées de l'utilisateurs
    $sql = 'INSERT INTO elements (id_article, balise, contenu, id_media, href, ordre, id_classe) VALUES (:id_article, :balise, :contenu, :id_media, :href, :order, :id_classe);';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);


    // on donne une valeur aux paramètres à partir des attributs de l'objet courant
    $query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);
    $query->bindValue(':balise', $this->balise, PDO::PARAM_STR);
    $query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
    $query->bindValue(':id_media', $this->id_media, PDO::PARAM_INT);
    $query->bindValue(':href', $this->href, PDO::PARAM_STR);
    $query->bindValue(':id_classe', $this->id_classe, PDO::PARAM_INT);
    $query->bindValue(':order', Element::getMaxOrder($this->id_article), PDO::PARAM_INT);

    // var_dump(Element::getMaxOrder($this->id_article));
    // Exécution de la requête
    $query->execute();

    $query->debugDumpParams();

    $this->id = $pdo->lastInsertId();
  }

  static function delete($id)
  {
    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'DELETE FROM elements WHERE id = :id;';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on lie le paramètre :id à la variable $id reçue
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();
  }

  function getMaxOrder($id_article)
  {

    $sql = 'SELECT MAX(ordre) + 1 AS maxOrder FROM elements WHERE id_article = :id_article;';

    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on lie le paramètre :id à la variable $id reçue
    $query->bindValue(':id_article', $id_article, PDO::PARAM_INT);

    // exécution de la requête
    $query->execute();

    // récupération de l'unique ligne
    $objet = $query->fetch(PDO::FETCH_ASSOC);

    if ($objet['maxOrder'] == null) {
      return 1;
    } else {
      return $objet['maxOrder'];
    }
  }

  function update()
  {
    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'UPDATE elements SET balise = :balise, contenu = :contenu, id_media = :id_media, href = :href, id_classe = :id_classe, id_article = :id_article WHERE id = :id';
    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur aux paramètres à partir des attributs de l'objet courant
    $query->bindValue(':id', $this->id, PDO::PARAM_INT);
    $query->bindValue(':balise', $this->balise, PDO::PARAM_STR);
    $query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
    $query->bindValue(':id_media', $this->id_media, PDO::PARAM_INT);
    $query->bindValue(':href', $this->href, PDO::PARAM_STR);
    $query->bindValue(':id_classe', $this->id_classe, PDO::PARAM_INT);
    $query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);

    // // var_dump('UPDATE elements SET alias = '.$this->alias.', balise = '.$this->balise.', text = '.$this->text.', src = '.$this->src.', alt = '.$this->alt.' WHERE id = '.$this->id.';');
    // exécution de la requête
    $query->execute();
  }

  static function orderUp($id, $ordre, $id_article)
  {
    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'UPDATE elements SET ordre = ordre + 1 WHERE ordre = :ordre - 1 AND id_article = :id_article; UPDATE elements SET ordre = :ordre - 1 WHERE id = :id;';
    // connexion à la base de données
    var_dump('UPDATE elements SET ordre = ordre + 1 WHERE ordre = ' . $ordre . ' - 1 AND id_article = ' . $id_article . '; UPDATE elements SET ordre = ' . $ordre . ' - 1 WHERE id = ' . $id . ';');
    $pdo = connexion();


    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur aux paramètres à partir des attributs de l'objet courant
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':ordre', $ordre, PDO::PARAM_INT);
    $query->bindValue(':id_article', $id_article, PDO::PARAM_INT);
    // var_dump('UPDATE elements SET ordre = '.$ordre.' WHERE id = '.$id.'; UPDATE elements SET ordre = '.$ordre.' WHERE ordre = '.$ordre.' AND id_article = '.$id_article.';');

    // exécution de la requête
    $query->execute();
  }

  static function orderDown($id, $ordre, $id_article)
  {
    // construction de la requête :nom, :prenom sont les valeurs à insérées
    $sql = 'UPDATE elements SET ordre = ordre - 1 WHERE ordre = :ordre + 1 AND id_article = :id_article; UPDATE elements SET ordre = :ordre + 1 WHERE id = :id;';
    // connexion à la base de données
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // on donne une valeur aux paramètres à partir des attributs de l'objet courant
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':ordre', $ordre, PDO::PARAM_INT);
    $query->bindValue(':id_article', $id_article, PDO::PARAM_INT);

    // // var_dump('UPDATE elements SET alias = '.$this->alias.', balise = '.$this->balise.', text = '.$this->text.', src = '.$this->src.', alt = '.$this->alt.' WHERE id = '.$this->id.';');
    // exécution de la requête
    $query->execute();
  }
}
