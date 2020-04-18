<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Repositories;
use App\User;

class UserRepository {

    public function teacher( $id ) {

    }

    public function getList( $num ) {
        //dd( User::with('role')->find(10));
        return User::with('role')->paginate(10);
    }

    public function getById($id) {
        return User::with('role')->find($id);
    }

}
