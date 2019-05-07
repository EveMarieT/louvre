<?php
namespace  App\Service;


use App\Entity\Booking;
use Twig\Environment;

class Mailer
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMessage(Booking $booking)
    {
        $message = new \Swift_Message("Votre reservation pour le musée");

        try {
            $message
                ->setFrom('monemail@louvre.fr')
                ->setTo($booking->getEmail())
                ->setBody(
                    $this->twig->render(
                        'emails/registration.html.twig', [
                            'booking' => $booking]
                    ),
                    'text/html'
                );
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }


        $this->mailer->send($message);
    //return $this->render('emails/registration.html.twig');
    }

}



