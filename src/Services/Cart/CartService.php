<?php
namespace App\Services\Cart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\CommandeRepository;

class CartService {
    protected $session;
    protected $CommandeRepository;
    public function __construct(SessionInterface $session, CommandeRepository $CommandeRepository){
        $this->session=$session;
        $this->CommandeRepository=$CommandeRepository;
    }
    public function add(int $id) {
        $panier=$this->session->get('panier', []);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else {
            $panier[$id]=1;
        }
        
        $this->session->set('panier', $panier);
    }
    
    public function getFullCart() : array {
        $panier=$this->session->get('panier', []);
        $panierWithData=[];
        foreach($panier as $id => $prix_total) {
            $panierWithData[]=[
            'product'=>$this->CommandeRepository->find($id),
            'prixtotal'=>$prix_total
        ];
        }
        return $panierWithData;
    }
    public function getTotal() : float {
        $total=0;
       
        foreach($this->getFullCart() as $item){
           
    
            $totalItem=
            $total+= $item['prixtotal'];
            
        }
        return $total;
    }
    
}