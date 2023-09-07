<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * Subscripti mailer.
 */
class SubscriptiMailer extends Mailer
{
    /**
     * Mailer's name.
     *
     * @var string
     */
    public static $name = 'Subscripti';

    public function subscriptionconfirmation($allarray) {
            

        $mailer = new Mailer();
        $mailer->setProfile('default');           
                
        $mailer
            ->setTo($allarray['msgemail'],$allarray['msgname'])
            //->setFrom(['saes.sistemas@gmail.com' => 'D@taCom'])
            //->setTo($peoplearray['email'], $peoplearray['name'])            
            //->setTo($peoplearray['email'])
            //->setCc('saes.card@gmail.com')
            //->setBcc('saes.card@gmail.com')
            ->setEmailFormat('html')            
            ->setViewVars(['useid' => $allarray['msgusrid'],'nome' => $allarray['msgname'],'evento' => $allarray['msgevedescription'],'valor' => $allarray['msgeveprice'] ,'datainicio' => $allarray['msgeveinicio'],'datafim' => $allarray['msgevefim'],'email' => $allarray['msgemail'],'eventoid' => $allarray['msgeveid'],'inscricao' => $allarray['msgsubid']])            
            ->setSubject(sprintf('ADBELEM SJC - CONFIRMAÇÃO DE PRÉ-INSCRIÇÃO, %s', $allarray['msgname']));
        
        $mailer->viewBuilder()
                ->setTemplate('subscriptionconfirmation')
                ->setLayout('subscriptionconfirmation');
        $mailer->Deliver();
        
       
   }
}
