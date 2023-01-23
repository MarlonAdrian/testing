<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredUserNotification extends Notification
{
    use Queueable;

    private string $username;
    private string $user_role;
    private string $password;

    public function __construct(string $user, string $password)
    {
        $this->username = $user;
        
        $this->password = $password;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $login_url = url('/login');
        return (new MailMessage)
            ->subject('Eres un cliente nuevo! Bienvenido a nuestro Ecommerce de Equipos Computacionales')
            ->line('Que tal' . " $this->username"."?")
            ->line('Has sido registrado en el sistema con el rol de cliente,')
            ->line('La contraseña que ha sido generada para que puedas ingresar el sistema es:' . " $this->password")
            ->line('Puedes iniciar sesión dando clic')
            ->action('Login', $login_url)
            ->line('Recuerda: cambia la contraseña cuando verifiques el email y acceso al sistema.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
