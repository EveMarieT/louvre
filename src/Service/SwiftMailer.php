public function index($name, \Swift_Mailer $mailer)
{
    $message = (new \Swift_Messager())
        ->setFrom('email')
        ->setTo('email')
        ->setBody(
            ->$this->renderView(
                    'emails/registration.html.twig',
                        ['name' => $name]
            ),
            'text/html'
        );

    $mailer->send($message);
    return $this->render('emails/registration.html.twig');
}
