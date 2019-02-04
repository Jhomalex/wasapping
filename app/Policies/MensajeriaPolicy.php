<?php

namespace App\Policies;

use App\User;
use App\Mensajeria;
use Illuminate\Auth\Access\HandlesAuthorization;

class MensajeriaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the mensajeria.
     *
     * @param  \App\User  $user
     * @param  \App\Mensajeria  $mensajeria
     * @return mixed
     */
    public function view(User $user, Mensajeria $mensajeria)
    {
        return $user === $mensajeria->user_id;
    }

    /**
     * Determine whether the user can create mensajerias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the mensajeria.
     *
     * @param  \App\User  $user
     * @param  \App\Mensajeria  $mensajeria
     * @return mixed
     */
    public function update(User $user, Mensajeria $mensajeria)
    {
        //
    }

    /**
     * Determine whether the user can delete the mensajeria.
     *
     * @param  \App\User  $user
     * @param  \App\Mensajeria  $mensajeria
     * @return mixed
     */
    public function delete(User $user, Mensajeria $mensajeria)
    {
        //
    }

    /**
     * Determine whether the user can restore the mensajeria.
     *
     * @param  \App\User  $user
     * @param  \App\Mensajeria  $mensajeria
     * @return mixed
     */
    public function restore(User $user, Mensajeria $mensajeria)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the mensajeria.
     *
     * @param  \App\User  $user
     * @param  \App\Mensajeria  $mensajeria
     * @return mixed
     */
    public function forceDelete(User $user, Mensajeria $mensajeria)
    {
        //
    }
}
