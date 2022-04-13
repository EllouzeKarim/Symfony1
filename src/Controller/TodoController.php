<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(SessionInterface $session): Response
    {
        if(!$session->has('todolist'))
        {
            $todos = array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $session->set('todolist',$todos);
            $this->addFlash('info',"Bienvenu");
        }
        return $this->render('todo/index.html.twig',);
    }

    #[Route('/addtodo/{name}/{content}',name:'app_addtodo') ]

    public function addtodo($name,$content,SessionInterface $session)
    {
        if(!$session->has('todolist'))
        {
            $this->addFlash('error',"La liste n'est pas encore initialisée");
        }
        else
        {
            $todos=$session->get('todolist');
            if(isset($todos[$name]))
            {
                $this->addFlash('error',"Ce todo existe déja");

            }
            else{
                $todos[$name]=$content;
                $session->set('todolist',$todos);
                $this->addFlash('success',"le Todo $name $content ajouté avec succés");
            }

        }
        return $this->redirectToRoute('app_todo');


    }

    #[Route('/deletetodo/{name}',name:'app_deletetodo') ]

    public function deletetodo($name,SessionInterface $session)
    {
        if(!$session->has('todolist'))
        {
            $this->addFlash('error',"La liste n'est pas encore initialisée");
        }
        else
        {
            $todos=$session->get('todolist');
            if(!isset($todos[$name]))
            {
                $this->addFlash('error',"Le todo $name n'existe pas");

            }
            else{
                unset($todos[$name]);
                $session->set('todolist',$todos);
                $this->addFlash('success',"le Todo $name supprimé avec succés");
            }

        }
        return $this->redirectToRoute('app_todo');


    }


    #[Route('/updatetodo/{name}/{content}',name:'app_updatetodo') ]

    public function updatetodo($name,$content,SessionInterface $session)
    {
        if(!$session->has('todolist'))
        {
            $this->addFlash('error',"La liste n'est pas encore initialisée");
        }
        else
        {
            $todos=$session->get('todolist');
            if(!isset($todos[$name]))
            {
                $this->addFlash('error',"Le todo $name n'existe pas");

            }
            else{
                $todos[$name]=$content;
                $session->set('todolist',$todos);
                $this->addFlash('success',"le Todo $name $content mis à jour avec succés");
            }

        }
        return $this->redirectToRoute('app_todo');

    }
    #[Route('/resettodo',name:'app_resettodo') ]

    public function resettodo(SessionInterface $session)
    {
        if(!$session->has('todolist'))
        {
            $this->addFlash('error',"La liste n'est pas encore initialisée");
        }
        else
        {
                $session->clear();
                $this->addFlash('success',"Votre session réinitialisée avec succés");

        }
        return $this->redirectToRoute('app_todo');

    }

}
