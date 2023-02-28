<?php
// déclaration d'une classe Auteur

class Couleur {
  public $id;
  public $idPage;
  public $hex;

  function __construct() {
    // conversion d'un attribut
    $this->id = intval($this->id);
 
    // remplace une valeur vide par autre chose
    if (empty($this->nom)) $this->nom = 'inconnu';
 
    // définit un attribut complémentaire (hors base de données)
    $this->attribut_complementaire = 'valeur hors base de données';
  }

  static function readAll() {
    // définition de la requête SQL
    $sql= 'select * from couleurs';

    // connexion
    $pdo = connexion();

    // préparation de la requête
    $query = $pdo->prepare($sql);

    // exécution de la requête
    $query->execute();

    // récupération de toutes les lignes sous forme d'objets
    $tableau = $query->fetchAll(PDO::FETCH_CLASS,'Couleur');

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
    $sql= 'SELECT * FROM couleurs WHERE id = :id;';

    $pdo = connexion();
 
    // préparation de la requête
    $query = $pdo->prepare($sql);
    
    // on donne une valeur au paramètre correspondant à la clé
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    
    // exécution de la requête
    $query->execute();

    // récupération de l'unique ligne
    $objet = $query->fetchObject('Couleur');
 
    // retourne l'objet contenant résultat
    return $objet;
  }
}
?>
