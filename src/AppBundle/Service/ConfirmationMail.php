<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 4/12/18
 * Time: 12:12 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Proposal;

/**
 * Class ConfirmationMail
 */
class ConfirmationMail
{
    private $mailer;
    private $templating;

    /**
     * ConfirmationMail constructor.
     * @param \Swift_Mailer     $mailer
     * @param \Twig_Environment $templating
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param Proposal $proposal
     * @param string   $mailTo
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function confirmAction(Proposal $proposal, string $mailTo)
    {
        $messageEmail = (new \Swift_Message('Hello Email'))
            ->setFrom('support@superblog.test')
            ->setTo($mailTo)
            ->setBody(
                $this->templating->render(':Emails:registration.html.twig', [
                    'name' => $proposal->getName(),
                ]),
                'text/html'
            );

        $this->mailer->send($messageEmail);
    }
}