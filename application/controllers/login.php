<?php

class Login extends Main_Controller{
	function index(){

        $user = new Entity\User;
        $user->setUsername('Joseph');
        $user->setPassword('secretPassw0rd');
        $user->setEmail('josephatwildlyinaccuratedotcom');
        $user->setFirstName('josephatwildlyinaccuratedotcom');
        $user->setLastName('josephatwildlyinaccuratedotcom');

        // When you have set up your database, you can persist these entities:
        $em = $this->doctrine->em;
        $em->persist($user);
        $em->flush();

        $this->load->view('include/header');
        $this->load->view('templates/menubar.php');
        $this->load->view('include/footer');
	}
}
