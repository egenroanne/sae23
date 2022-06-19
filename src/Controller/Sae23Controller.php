<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Articles;
use App\Entity\Prestations;
use App\Entity\Commandes;
use Doctrine\ORM\EntityManagerInterface;
use PDO;

class Sae23Controller extends AbstractController
{
    /**
     * @Route("/sae23", name="app_sae23")
     */
    public function index(): Response
    {

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("select id,nom,image,prix from articles");
        $req -> execute();

        $articles = $req -> fetchAll();
        $req -> closeCursor();
        $con = null;

        return $this->render('sae23/index.html.twig', [
            'articles' => $articles
        ]);
    }
	
	/**
     * @Route("/sae23/conadmin", name="app_conadmin")
     */
    public function conadmin(): Response
    {
        return $this->render('sae23/conadmin.html.twig', [
            'message' => '',
        ]);
    }
	
	/**
     * @Route("/sae23/conadminn", name="app_conadminn")
     */
    public function conadminn(Request $request): Response
    {
		
		$user = $request->request->get("user");
		$motdepasse = $request->request->get("password");
		
		if($user == "eren" && $motdepasse == "ereneren"){
			return $this->render('sae23/pageadmin.html.twig');
		}else{
			return $this->render('sae23/conadmin.html.twig', [
				'message' => 'User ou password non valide',
			]);
		}
		
    }

    /**
     * @Route("/sae23/pageadmin", name="app_pageadmin")
     */
    public function pageadmin(): Response
    {
        return $this->render('sae23/pageadmin.html.twig');
    }
	
	/**
     * @Route("/sae23/article", name="app_article")
     */
    public function article(Request $request): Response
    {
		$articleid = $request -> request -> get("articleid");

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("select * from articles where id = ?");
        $req -> bindParam(1, $articleid);
        $req -> execute();

        $article = $req -> fetchAll();
        $req -> closeCursor();

        $req = $con -> prepare("select * from prestations");
        $req -> execute();

        $prestations = $req -> fetchAll();
        $req -> closeCursor();

        $con = null;
		
        return $this->render('sae23/article.html.twig', [
            'article' => $article[0],
            'prestations' => $prestations
        ]);
    }

    /**
     * @Route("/sae23/achatform", name="app_sae23_achatform")
     */
    public function achatform(Request $request): Response
    {

        $prixtotal = $request -> request -> get("prixs");
        $articleid = $request -> request -> get("articleid");
        $garantie = $request -> request -> get("garantie");
        $cadeau = $request -> request -> get("cadeau");
        $envoierapide = $request -> request -> get("envoierapide");

        return $this->render('sae23/commander.html.twig', [
            'prixtotal' => $prixtotal,
            'articleid' => $articleid,
            'garantie' => $garantie,
            'cadeau' => $cadeau,
            'envoierapide' => $envoierapide
        ]);
    }

    /**
     * @Route("/sae23/gestionarticles", name="app_sae23_gestionarticles")
     */
    public function gestionarticles(): Response
    {

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("select id,nom,image,prix from articles");
        $req -> execute();

        $articles = $req -> fetchAll();
        $req -> closeCursor();
        $con = null;

        return $this->render('sae23/gestionarticle.html.twig', [
            'array' => $articles,
        ]);
    }

    /**
     * @Route("/sae23/ajoutarticle", name="app_sae23_ajoutarticle")
     */
    public function ajoutarticle(): Response
    {
        return $this->render('sae23/ajoutarticle.html.twig');
    }

    /**
     * @Route("/sae23/ajouttarticle", name="app_sae23_ajouttarticle")
     */
    public function ajouttarticle(Request $request, EntityManagerInterface $entityManager): Response
    {

        $nom = $request->request->get("nom");
        $image = $request->files->get("image");
        $prix = $request->request->get("prixx");
        $destination = $this->getParameter("kernel.project_dir")."/public";
        $image -> move($destination);

        $articles = new articles();
        $articles -> setNom($nom);
        $articles -> setImage($image->getFileNAme());
        $articles -> setPrix(intval($prix));
        $entityManager -> persist($articles);
        $entityManager -> flush();

        return $this -> gestionarticles($entityManager);

    }

    /**
     * @Route("/sae23/suparticle", name="app_sae23_suparticle")
     */
    public function suparticle(Request $request, EntityManagerInterface $entityManager): Response
    {

        $articleid = intval($request->request->get("articlecheck"));

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("delete from articles where id = ?");
        $req -> bindParam(1, $articleid);
        $req -> execute();

        $req -> closeCursor();
        $con = null;

        return $this -> gestionarticles($entityManager);
    }

    /**
     * @Route("/sae23/commandes", name="app_sae23_commandes")
     */
    public function commandes(): Response
    {

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("select * from commandes");
        $req -> execute();

        $commandes = $req -> fetchAll();
        $req -> closeCursor();
        $con = null;

        return $this->render('sae23/commandes.html.twig', [
            'array' => $commandes,
        ]);

    }

    /**
     * @Route("/sae23/envoiecommande", name="app_sae23_envoiecommande")
     */
    public function envoiecommande(Request $request): Response
    {

        $commandeid = $request->request->get("commandecheck");
        $envoie = 1;

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("update commandes set envoie = ? where id = ?");
        $req -> bindParam(1, $envoie);
        $req -> bindParam(2, $commandeid);
        $req -> execute();

        return $this -> commandes();

    }

    /**
     * @Route("/sae23/prestations", name="app_sae23_prestations")
     */
    public function prestations(): Response
    {

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("select * from prestations");
        $req -> execute();

        $prestations = $req -> fetchAll();
        $req -> closeCursor();
        $con = null;

        return $this->render('sae23/prestations.html.twig', [
            'array' => $prestations
        ]);

    }

    /**
     * @Route("/sae23/ajoutprestation", name="app_sae23_ajoutprestation")
     */
    public function ajoutprestation(): Response
    {
        return $this->render('sae23/ajoutprestation.html.twig');
    }

    /**
     * @Route("/sae23/ajouttprestation", name="app_sae23_ajouttprestation")
     */
    public function ajouttprestation(Request $request, EntityManagerInterface $entityManager): Response
    {

        $nom = $request->request->get("nom");
        $prix = $request->request->get("prix");

        $prestations = new prestations();
        $prestations -> setNom($nom);
        $prestations -> setPrix(intval($prix));
        $entityManager -> persist($prestations);
        $entityManager -> flush();

        //$nom = str_replace('"', '', $nom);
        //$nom = "'" . $nom . "'";

        $con = new PDO("mysql:host=localhost:3306;dbname=sae23", "roott", "roott");
        $req = $con -> prepare("alter table commandes add ? boolean not null default false;");
        $req -> bindParam(1, $nom);
        $req -> execute();
        $req -> closeCursor();
        $con = null;

        return $this -> prestations();

    }

    /**
     * @Route("/sae23/achat", name="app_sae23_achat")
     */
    public function achat(Request $request, EntityManagerInterface $entityManager): Response
    {

        $prix = $request->request->get("prix");
        $nom = $request->request->get("nom");
        $tel = $request->request->get("tel");
        $pays = $request->request->get("pays");
        $ville = $request->request->get("ville");
        $adresse = $request->request->get("adresse");
        $codepostal = $request->request->get("codepostal");
        $articleid = $request->request->get("articleid");
        $garantie = $request->request->get("garantie");
        $cadeau = $request->request->get("cadeau");
        $envoierapide = $request->request->get("envoierapide");

        $commande = new commandes();
        $commande -> setArticle($entityManager -> getRepository(articles::class) -> findOneById($articleid));
        $commande -> setNom($nom);
        $commande -> setTelephone($tel);
        $commande -> setPays($pays);
        $commande -> setVille($ville);
        $commande -> setAdresse($adresse);
        $commande -> setCodepostal(intval($codepostal));
        $commande -> setPrix(intval($prix));
        $commande -> setGarantie(intval($garantie));
        $commande -> setCadeau(intval($cadeau));
        $commande -> setEnvoierapide(intval($envoierapide));
        $commande -> setEnvoie(0);
        $entityManager -> persist($commande);
        $entityManager -> flush();

       return $this->render('sae23/achat.html.twig');
    }

    /**
     * @Route("/sae23/tp", name="app_sae23_tp")
     */
    public function tp(): Response
    {
        return $this->render('sae23/tp.html.twig');
    }

}
