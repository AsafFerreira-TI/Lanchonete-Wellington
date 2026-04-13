<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SobreController extends Controller
{
    public function index(){
        $aboutus = 'Somos a Lanchonete Wellington, um lugar acolhedor e pacato. Aqui, servimos todo tipo de prato, segundo
        o gosto do cliente. Sempre valorizamos as conexões criadas com o fim de unir nossos clientes e colaboradores. Mais 
        do que uma lanchonete, somos uma família, onde todos são conhecidos, e todos são beneficiados. Temos reconhecimento
        nacional e internacional por nossos trabalhos. 
         Em 2023, ganhamos o selo #GreatPlaceToWork, e isso foi uma grande conquista para nós todos, sem falar em outros selos 
        reconhecidos mundialmente, que reconhecem nossa marca, história e identidade. 
         Mais que uma lanchonete, somos uma família. Vem para a Wellington!';

        return view('sobre', compact('aboutus'));
    }
}
