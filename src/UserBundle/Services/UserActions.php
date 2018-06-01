<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 5/31/18
 * Time: 1:15 PM
 */

namespace UserBundle\Services;

use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class UserActions
 */
class UserActions
{
    private $userManager;
    private $factory;
    private $session;
    private $dispatcher;
    private $tokenStorage;

    /**
     * UserActions constructor.
     * @param UserManager              $userManager
     * @param EncoderFactory           $factory
     * @param TokenStorage             $tokenStorage
     * @param EventDispatcherInterface $dispatcher
     * @param Session                  $session
     */
    public function __construct(UserManager $userManager, EncoderFactory $factory, TokenStorage $tokenStorage, EventDispatcherInterface $dispatcher, Session $session)
    {
        $this->factory = $factory;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
        $this->dispatcher = $dispatcher;
        $this->session = $session;
    }

    /**
     * @param string $email
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function register($email, $username, $password)
    {
        $emailExist = $this->userManager->findUserByEmail($email);

        // Check if the user exists to prevent Integrity constraint violation error in the insertion
        if ($emailExist) {
            return [
                "status" => "error",
                "message" => "This e-mail is already exists!",
            ];
        }

        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
        // this method will encrypt the password with the default settings :)
        $user->setPlainPassword($password);
        $this->userManager->updateUser($user);

        return [
            "status" => "success",
            "message" => "Welcome, you registered successfully!",
        ];
    }

    /**
     * @param Request $request
     * @param string  $userName
     * @param string  $password
     *
     * @return array
     */
    public function loginAction(Request $request, $userName, $password)
    {
        $user = $this->userManager->findUserByUsername($userName);
        // Or by yourself

        // Check if the user exists !
        if (!$user) {
            return [
                "status" => "error",
                "message" => "There is no user!",
            ];
        }

        /// Start verification
        $encoder = $this->factory->getEncoder($user);
        $salt = $user->getSalt();

        if (!$encoder->isPasswordValid($user->getPassword(), $password, $salt)) {
            return [
                "status" => "error",
                "message" => "Login or password is incorrect!",
            ];
        }
        /// End Verification

        // The password matches ! then proceed to set the user in session

        //Handle getting or creating the user entity likely with a posted form
        // The third parameter "main" can change according to the name of your firewall in security.yml
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        // If the firewall name is not main, then the set value would be instead:
        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
        $this->session->set('_security_main', serialize($token));

        // Fire the login event manually
        $event = new InteractiveLoginEvent($request, $token);
        $this->dispatcher->dispatch("security.interactive_login", $event);

        /*
         * Now the user is authenticated !!!!
         * Do what you need to do now, like render a view, redirect to route etc.
         */
        return [
            "status" => "success",
            "message" => "Welcome, ".$user->getUsernameCanonical()."!",
        ];
    }
}