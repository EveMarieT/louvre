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

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     *
     *
     */

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMessage(Booking $booking)
    {
        $message = new \Swift_Message("Votre réservation pour le musée");


        try {
            $message
                ->setFrom('monemail@louvre.fr')
                ->setTo($booking->getEmail())
                ->setBody(

                    $this->twig->render(
                        'emails/registration.html.twig', [
                            'booking' => $booking,
                            'tickets' => $booking->getTickets(),
                            ]

                    ),
                    'text/html'
                );
        } catch (\Twig_Error_Loader $e) {
        } catch (\Twig_Error_Runtime $e) {
        } catch (\Twig_Error_Syntax $e) {
        }


        $this->mailer->send($message);

    }

}



