<?php

namespace Melnik\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Melnik\BlogBundle\Entity\Enquiry;
use Melnik\BlogBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $blogs = $em->getRepository('MelnikBlogBundle:Blog')
            ->getLatestBlogs();

        return $this->render('MelnikBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }

    public function aboutAction()
    {
        return $this->render('MelnikBlogBundle:Page:about.html.twig');
    }

    public function guestbookAction()
    {
        $enquiry = new Enquiry();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new EnquiryType(), $enquiry);

        $enquirys = $em->getRepository('MelnikBlogBundle:Enquiry')->findAll();

        $request = $this->getRequest();
        if ($request->getMethod() === 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $enquiry = $form->getData();
                $em->persist($enquiry);
                $em->flush();

                return $this->redirect($this->generateUrl('melnik_blog_guestbook'));
            }
        }

        return $this->render('MelnikBlogBundle:Page:guestbook.html.twig', array(
            'form' => $form->createView(),
            'enquirys' => $enquirys         ));
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $tags = $em->getRepository('MelnikBlogBundle:Blog')
            ->getTags();

        $tagWeights = $em->getRepository('MelnikBlogBundle:Blog')
            ->getTagWeights($tags);

        return $this->render('MelnikBlogBundle:Page:sidebar.html.twig', array(
            'tags' => $tagWeights
        ));
    }
}
