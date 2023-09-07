<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * Users mailer.
 */
class UsersMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Users';

    public function emailconfirmation($userarray) {

     

        $mailer = new Mailer();
        $mailer->setProfile('default');           
                
        $mailer
            ->setTo($userarray['email'],$userarray['name'])
            //->setFrom(['saes.sistemas@gmail.com' => 'D@taCom'])
            //->setTo($peoplearray['email'], $peoplearray['name'])            
            //->setTo($peoplearray['email'])
            //->setCc('saes.card@gmail.com')
            //->setBcc('saes.card@gmail.com')
            ->setEmailFormat('html')            
            ->setViewVars(['nome' => $userarray['name'],'hash' => $userarray['password'],'id' => $userarray['id'],'email' => $userarray['email']])            
            ->setSubject(sprintf('ADBELEM SJC - RECUPERAÇÃO DE SENHA, %s', $userarray['name']));
        
        $mailer->viewBuilder()
                ->setTemplate('emailconfirmation')
                ->setLayout('emailconfirmation');
       // $mailer->Send();

       
       //$file = new file(WWW_ROOT.'files'.DS.'ebook.pdf');

       /* 
       $mailer->setAttachments([
               $file->name => [
                   'file' => $file->path,
                   'mimetype' => $file->mime(),
                   'contentId' => $file->md5()
               ]
           ]); 

        */   
        $mailer->Deliver();
        
        
                  
       //$mailer->deliver($peoplearray['email'],'teste2','teste3',['from' => 'saes.sistemas@gmail.com']);

        //Email::deliver('you@example.com', 'Subject', 'Message', ['from' => 'me@example.com']);
                
    //    var_dump($mailer);        
      //  exit;
    
   }
    
    public function accountconfirmation($userarray) {

     

        $mailer = new Mailer();
        $mailer->setProfile('default');           
                
        $mailer
            ->setTo($userarray['email'],$userarray['name'])            
            ->setEmailFormat('html')            
            ->setViewVars(['nome' => $userarray['name'],'hash' => $userarray['password'],'id' => $userarray['id'],'email' => $userarray['email']])            
            ->setSubject(sprintf('ADBELEM SJC - CONFIRMAÇÃO DE CONTA, %s', $userarray['name']));
        
        $mailer->viewBuilder()
                ->setTemplate('accountconfirmation')
                ->setLayout('accountconfirmation');
       // $mailer->Send();

       
       //$file = new file(WWW_ROOT.'files'.DS.'ebook.pdf');

       
        $mailer->Deliver();        
        
    
   }

   public function old_emailconfirmation($user)
   {
       $this
           ->setTo($user->email)
           ->setSubject('Reset password')           
           ->setEmailFormat('html')
           ->setViewVars(['token' => $user->id,'username' => $user->username]);

        $mailer->viewBuilder()
           ->setTemplate('emailconfirmation')
           ->setLayout('emailconfirmation');

   }


}
