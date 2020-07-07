<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\TwitterPage;
use App\Entity\FacebookPage;
use App\Entity\InstagramPage;
use App\Form\AddPageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class PanelController extends Controller
{

    /**
     * @Route("/panel", name="panel")
     */
    public function panel()
    {
        return $this->render('panel/panel.html.twig');
    }

    /**
     * @Route("/panel/listpage/facebook", name="panel_list_page")
     */
    public function listpage()
    {
        $repository = $this->getDoctrine()->getRepository(FacebookPage::class);
        $facebookpages = $repository->findAll();
        
        return $this->render('panel/listpage/facebook.html.twig', array(
            "facebook_pages" => $facebookpages
        ));
    }

    /**
     * @Route("/panel/listpage/instagram", name="panel_list_page_ins")
     */
    public function listpage_ins()
    {
        $repository = $this->getDoctrine()->getRepository(InstagramPage::class);
        $Instagrampages = $repository->findAll();
        
        return $this->render('panel/listpage/instagram.html.twig', array(
            "Instagram_pages" => $Instagrampages
        ));
    }

    /**
     * @Route("/panel/listpage/twitter", name="panel_list_page_twt")
     */
    public function listpage_twt()
    {
        $repository = $this->getDoctrine()->getRepository(TwitterPage::class);
        $twitterpages = $repository->findAll();
        
        return $this->render('panel/listpage/twitter.html.twig', array(
            "Twitter_pages" => $twitterpages
        ));
    }

    /**
     * @Route("/panel/sss", name="panel_sss")
     */
    public function help()
    {
        return $this->render('panel/sss.html.twig');
    }

    /**
     * @Route("/panel/productpage/facebook", name="panel_productpage_facebook")
     */
    public function product(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(FacebookPage::class);
        $radioAll = "checked";
        $radioVerified = "";
        $radioNotVerified = "";
        
        if ($request->getMethod() == 'POST') {
            $radioAll = "";
            $valueMin = $request->get('value_min');
            $valueMax = $request->get('value_max');
            $verified = $request->get('verified');
            
            $facebookpages = null;
            if ($verified == "onayli" || $verified == "onaysiz") {
                if ($verified == "onayli") {
                    $radioVerified = "checked";
                    $verified = 1;
                } else {
                    $verified = 0;
                    $radioNotVerified = "checked";
                }
                $facebookpages = $this->getDoctrine()
                    ->getManager()
                    ->createQueryBuilder()
                    ->select('p')
                    ->from('App\Entity\FacebookPage', 'p')
                    ->where('p.isVertified = ?1 AND p.price >= ?2  AND p.price <= ?3')
                    ->setParameter(1, $verified)
                    ->setParameter(2, $valueMin)
                    ->setParameter(3, $valueMax)
                    ->getQuery()
                    ->getResult();
            } else {
                $radioAll = "checked";
                $facebookpages = $this->getDoctrine()
                    ->getManager()
                    ->createQueryBuilder()
                    ->select('p')
                    ->from('App\Entity\FacebookPage', 'p')
                    ->where('p.price >= ?1  AND p.price <= ?2')
                    ->setParameter(1, $valueMin)
                    ->setParameter(2, $valueMax)
                    ->getQuery()
                    ->getResult();
            }
            
            return $this->render('panel/productpage/facebook.html.twig', array(
                "facebook_pages" => $facebookpages,
                "valueMax" => $valueMax,
                "valueMin" => $valueMin,
                "radioAll" => $radioAll,
                "radioVerified" => $radioVerified,
                "radioNotVerified" => $radioNotVerified
            ));
        } else {
            $facebookpages = $repository->findAll();
            return $this->render('panel/productpage/facebook.html.twig', array(
                "facebook_pages" => $facebookpages,
                "valueMax" => "1000",
                "valueMin" => "0",
                "radioAll" => $radioAll,
                "radioVerified" => $radioVerified,
                "radioNotVerified"  => $radioNotVerified
            ));
        }
    }

    /**
     * @Route("/panel/productpage/instagram", name="panel_productpage_instagram")
     */
    public function product2()
    {
        $repository2 = $this->getDoctrine()->getRepository(InstagramPage::class);
        $instagrampages = $repository2->findAll();
        
        return $this->render('panel/productpage/instagram.html.twig', array(
            
            "instagram_pages" => $instagrampages
        ));
    }

    /**
     * @Route("/panel/productpage/twitter", name="panel_productpage_twitter")
     */
    public function product3()
    {
        $repository2 = $this->getDoctrine()->getRepository(TwitterPage::class);
        $twitterpages = $repository2->findAll();
        
        return $this->render('panel/productpage/twitter.html.twig', array(
            
            "twitter_pages" => $twitterpages
        ));
    }

    /**
     * @Route("/panel/productpage/twitter/detail/{id}", name="panel_productpage_twitter_detail")
     */
    public function twitterDetail(TwitterPage $page)
    {
        return $this->render('panel/productpage/detail/twitter.html.twig', array(
            "page" => $page
        ));
    }

    
    
    
    /**
     * @Route("/panel/account/settings", name="panel_account_settings")
     */
    public function settings(Request $request)
    {
        
        $oldname=$this->getUser('$firstName');
        $newname = $request->get('newname');
        if ($newname != null) {
            $id = $this->getUser()->getId();
            $user_repository = $this->getDoctrine()->getRepository(User::class);
            $em = $this->getDoctrine()->getManager();
            
            $user = $user_repository->find($id);
            $user->setfirstName($newname);
            $em->flush();
            
            
        }
        return $this->render('panel/account/settings.html.twig', array(
            "usernewname" => $oldname
        ));
    }
    
    
       /**
     * @Route("/panel/addpage", name="panel_add_page")
     */
    public function addpage(Request $request)
    {
        $form = $this->createForm(AddPageType::class);
        
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $pagename = $form["pagename"]->getData();
            $pagelink = $form["pagelink"]->getData();
            $description = $form["description"]->getData();
            $price = $form["price"]->getData();
            $pageimage = $form["pageimage"]->getData();
            if (strpos($pagelink, 'facebook') !== false) {
                $page = new FacebookPage();
                $page->setPageName($pagename);
                $page->setPageLink($pagelink);
                $page->setUser($this->getUser());
                $page->setDescription($description);
                $page->setPrice($price);
                $page->setImageLink($pageimage);
                $page->setIsVertified(false);
                $em->persist($page);
                $em->flush();
                return $this->render('panel/panel.html.twig');
            } else if (strpos($pagelink, 'instagram') !== false) {
                $page = new InstagramPage();
                $page->setPageName($pagename);
                $page->setPageLink($pagelink);
                $page->setUser($this->getUser());
                $page->setDescription($description);
                $page->setPrice($price);
                $page->setImageLink($pageimage);
                $page->setIsVertified(false);
                $em->persist($page);
                $em->flush();
                return $this->render('panel/panel.html.twig');
            } else if ((strpos($pagelink, 'twitter') !== false)) {
                $page = new twitterPage();
                $page->setPageName($pagename);
                $page->setPageLink($pagelink);
                $page->setUser($this->getUser());
                $page->setDescription($description);
                $page->setPrice($price);
                $page->setImageLink($pageimage);
                $page->setIsVertified(false);
                $em->persist($page);
                $em->flush();
                return $this->render('panel/panel.html.twig');
            }
            return $this->redirectToRoute('home');
        }
        
        return $this->render('panel/addpage/addpage.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/panel/vertify/twitter/{id}", name="panel_vertify_twitter")
     */
    public function twitterVertify(TwitterPage $page)
    {
        return $this->render('panel/vertify/twitter.html.twig', array(
            "page" => $page
        ));
    }
}
