<?php

include('include/twig.php');
include('include/connexion.php');
include('include/media.php');
include('include/couleur.php');
include('include/element.php');
include('include/article.php');
include('include/page.php');
include('include/famille.php');
include('include/classe.php');

$twig = init_twig();

/* attribution des valeurs GET */
$page = (isset($_GET['page']) ? $_GET['page'] : '');
$action = (isset($_GET['action']) ? $_GET['action'] : 'read');
$id = (isset($_GET['id']) ? $_GET['id'] : 0);
$order = (isset($_GET['order']) ? $_GET['order'] : 0);
$id_article = (isset($_GET['id_article']) ? $_GET['id_article'] : 0);

$data = [];
$model = 'main.twig';

switch ($page) {
    case 'element':
        switch ($action) {
            case 'create':
                $element = new Element;
                $element->chargePOST();
                echo '<pre>';
                print_r($element);
                echo '</pre>';
                $element->create();
                // header('Location: index.php?page=element');
                break;
            case 'new':
                $model = 'createElement.twig';
                $data = [
                    'articles' => Article::readAll(),
                    'classes' => Classe::readAll(),
                    'medias' => Media::readAll()
                ];

                var_dump($data['medias']);
                break;
            case 'delete':
                Element::delete($id);
                header('Location: index.php?page=article&action=edit&id=' . $id_article);
                break;
            case 'edit':
                $model = 'alterElement.twig';
                $data = [
                    'element' => Element::readOne($id),
                    'classes' => Classe::readAll(),
                    'medias' => Media::readAll()
                ];
                break;
            case 'update':
                $element = new Element;
                $element->chargePOST();
                echo '<pre>';
                print_r($element);
                echo '</pre>';
                $element->update();
                // header('Location: index.php?page=element');
                break;
            case 'up':
                Element::orderUp($id, $order, $id_article);
                header('Location: index.php?page=article&action=edit&id=' . $id_article);
                break;
            case 'down':
                Element::orderDown($id, $order, $id_article);
                header('Location: index.php?page=article&action=edit&id=' . $id_article);
                break;
            default:
                header('Location: index.php?page=element&action=new');
                break;
        }
        break;
    case 'article':
        switch ($action) {
            case 'read':
                if ($id > 0) {
                    $model = 'article.twig';
                    $data = [
                        'elements' => Article::readElements($id),
                        'article' => Article::readOne($id)
                    ];
                } else {
                    $model = 'articles.twig';
                    $data = [
                        'articles' => Article::readAll($id),
                    ];
                }
                break;
            case 'create':
                $article = new Article;
                $article->chargePOST();
                $article->create();
                var_dump($article->id_media);
                // header('Location: index.php?page=article');
                break;
            case 'new':
                $model = 'createArticle.twig';
                $data = [
                    'pages' => Page::readAll(),
                    'couleurs' => Couleur::readAll(),
                    'medias' => Media::readAll()
                ];
                break;
            case 'delete':
                Article::delete($id);
                header('Location: index.php?page=article');
                break;
            case 'edit':
                $model = 'alterArticle.twig';
                $data = [
                    'elements' => Article::readElements($id),
                    'article' => Article::readOne($id)
                ];
                break;
            case 'editArticle':
                $model = 'alterArticleAttribute.twig';
                $data = ['article' => Article::readOne($id)];
                break;
            case 'update':
                $article = new Article;
                $article->chargePOST();
                echo '<pre>';
                print_r($article);
                echo '</pre>';
                $article->update();
                // header('Location: index.php?page=article&action=edit&id=' . $article->id);
                break;
        }
        break;
    case 'page':
        switch ($action) {
            case 'read':
                if ($id > 0) {
                    $model = 'page.twig';
                    $data = [
                        'articles' => Page::readArticles($id),
                        'page' => Page::readOne($id)
                    ];
                } else {
                    $model = 'pages.twig';
                    $data = ['pages' => Page::readAll()];
                }
                break;
            case 'create':
                $actualPage = new Page;
                $actualPage->chargePOST();
                $actualPage->create();
                // header('Location: index.php?page=article');
                break;
            case 'new':
                $data = ['familles' => Famille::readAll()];
                // var_dump($data);
                $model = 'createPage.twig';
                break;
            case 'delete':
                Page::delete($id);
                // header('Location: index.php?page=article');
                break;
            case 'edit':
                // var_dump($id);
                $model = 'alterPage.twig';
                $data = [
                    'familles' => Famille::readAll(),
                    'page' => Page::readOne($id)
                ];
                break;
            case 'update':
                $actualPage = new Page;
                $actualPage->chargePOST();
                $actualPage->update();
                // header('Location: index.php?page=article&action=edit&id='.$article->id);
                break;
        }
        break;
    case 'media':
        switch ($action) {
            case 'read':
                $model = 'medias.twig';
                $data = [
                    'medias' => Media::readAll()
                ];
            break;
            case 'new':
                $model = 'createMedia.twig';
                break;
            case 'upload':
                $media = new Media;
                $media->chargePOST();
                $media->upload();
                // header('Location: index.php?page=article');
                break;
            case 'delete':
                Media::delete($id);
                // header('Location: index.php?page=article');
            break;
    default:
        $model = 'main.twig';
        $data = [
            'pages' => Page::readAll(),
            'articles' => Article::readAll()
        ];
}
}

echo $twig->render($model, $data);
