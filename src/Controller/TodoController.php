<?php
    namespace App\Controller;

    use App\Entity\Todo;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    class TodoController extends AbstractController{
        /**
         * @Route("/", name="todo_list")
         * @Method({"GET"})
         */
        public function index(){

            $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
            return $this->render('todos/index.html.twig', array('todos' => $todos));
        }

        /**
         * @Route("/todo/new", name="new_todo")
         * Method({"GET", "POST"})
         */
        public function new(Request $request){
            $todo = new Todo();

            $form = $this->createFormBuilder($todo)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('isDone', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getform();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $todo = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($todo);
                $entityManager->flush();
                return $this->redirectToRoute('todo_list');
            }
            return $this->render('todos/new.html.twig', array('form' => $form->createView()));
        }
 /**
         * @Route("/todo/edit/{id}", name="edit_todo")
         * Method({"GET", "POST"})
         */
        public function edit(Request $request, $id){
            $todo = new Todo();
            $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

            $form = $this->createFormBuilder($todo)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array('attr' => array('class' => 'form-control')))
            ->add('isDone', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getform();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                return $this->redirectToRoute('todo_list');
            }
            return $this->render('todos/edit.html.twig', array('form' => $form->createView()));
        }

          /**
         * @Route("/todo/{id}", name="todo_show")
         */
        public function show($id){
            $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

            return $this->render('todos/show.html.twig', array('todo'=>$todo));
        }
        /**
         * @Route("todo/delete/{id}")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id){
            $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($todo);
            $entityManager->flush();
            
            $response = new Response();
            $response->send();

        }
    }