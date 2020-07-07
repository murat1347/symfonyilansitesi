<?php
namespace App\Controller;

use App\Entity\Communicate;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class MessageController extends Controller
{

    /**
     * @Route("/panel/message/", name="message")
     */
    public function message()
    {
        
        $query = $this->getDoctrine()->getEntityManager()->createQuery('SELECT c FROM App\Entity\Communicate c, App\Entity\Message m WHERE c.id = m.communicate_id AND (c.reciver= ?1 OR c.sender = ?1)  order by m.id DESC');
        $communicates = $query->setParameter(1, $this->getUser()->getId())->getResult();
        
        $sender = $communicates[0]->getSender()->getId();
        $reciver = $communicates[0]->getReciver()->getId();
        
        if($this->getUser()->getId() == $sender){
            return $this->redirectToRoute('messagesee', array('userid' => $reciver));
            
        }else{
            return $this->redirectToRoute('messagesee', array('userid' => $sender));
        }  
    }

    /**
     * @Route("/panel/message/{userid}", name="messagesee")
     */
    public function messagesee($userid)
    {
        $crepository = $this->getDoctrine()->getRepository(Communicate::class);
        $user_repository = $this->getDoctrine()->getRepository(User::class);
        $receiver = $user_repository->find($userid);
        
        $leftcommunicates = $crepository->findOneBy(array(
            'sender' => $this->getUser(),
            'reciver' => $userid
        ));
        $rightcommunicates = $crepository->findOneBy(array(
            'sender' => $userid,
            'reciver' => $this->getUser()
        ));
        if ($leftcommunicates || $rightcommunicates) {
            $message_repository = $this->getDoctrine()->getRepository(Message::class);
            $messages = null;
            $comId = 0;
            if ($leftcommunicates) {
                $comid = $leftcommunicates->getId();
            } else if ($rightcommunicates) {
                $comid = $rightcommunicates->getId();
            }
            
            $messagecount = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select('count(1)')
            ->from('App\Entity\Message', 'm')
            ->where('m.communicate_id = ?1')
            ->setParameter(1, $comid)
            ->getQuery()
            ->getSingleScalarResult();
            if($messagecount < 8){
                $messagecount = 8;
            }
            
            $messages = $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder()
                ->select('m')
                ->from('App\Entity\Message', 'm')
                ->where('m.communicate_id = ?1')
                ->setParameter(1, $comid)
                ->setFirstResult($messagecount-8)
                ->setMaxResults(8)
                ->getQuery()
                ->getResult();
          
          
                $summaryMessages =  $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder()
                ->select('c')
                ->from('App\Entity\Communicate', 'c')
                ->where('c.reciver= ?1 OR c.sender = ?1')
                ->setParameter(1, $this->getUser()->getId())
                ->getQuery()
                ->getResult();
                
                
                    
                
            return $this->render('panel/message/messagesee.html.twig', array(
                'messages' => $messages,
                'user' => $this->getUser(),
                'receiver' => $userid,
                'sentuser' => $receiver,
                'summarymessages' => $summaryMessages
            ));
        } else if ($userid != $this->getUser()->getId() && $receiver != null) {
            
            $em = $this->getDoctrine()->getManager();
            $com = new Communicate();
            $com->setSender($this->getUser());
            
            $com->setReciver($receiver);
            $em->persist($com);
            $em->flush();
        }
        
        // $mrepository = $this->getDoctrine()->getRepository(Message::class);
        // $mesages = $repository->findAll();
        
        return $this->render('panel/message/messagesee.html.twig');
    }

    /**
     * @Route("/panel/messagesend", name="messagesend")
     */
    public function messagesend(Request $request)
    {
        $text = $request->request->get('message');
        $receiver = $request->request->get('receiver');
        $crepository = $this->getDoctrine()->getRepository(Communicate::class);
        $user_repository = $this->getDoctrine()->getRepository(User::class);
        $message_repository = $this->getDoctrine()->getRepository(Message::class);
        
        $em = $this->getDoctrine()->getManager();
        $message = new Message();
        $message->setText($text);
        $message->setUser($this->getUser());
        
        $leftcommunicates = $crepository->findOneBy(array(
            'sender' => $this->getUser(),
            'reciver' => $receiver
        ));
        if ($leftcommunicates) {
            $message->setCommunicate_id($leftcommunicates);
        } else {
            $rightcommunicates = $crepository->findOneBy(array(
                'sender' => $receiver,
                'reciver' => $this->getUser()
            ));
            if ($rightcommunicates) {
                $message->setCommunicate_id($rightcommunicates);
            }
        }
        
        $em->persist($message);
        $em->flush();
        return $this->redirectToRoute('messagesee', array(
            'userid' => $receiver
        ));
    }
}
       