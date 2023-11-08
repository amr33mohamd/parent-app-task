<?php


namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\ProviderRepository;


class UserService
{
   
    /**
     * UserService constructor.
     *
     * @param userRepository $userRepository
     */
    public function __construct(UserRepository $userRepository,ProviderRepository $providerRepository)
    {
        $this->userRepository = $userRepository;
        $this->providerRepository = $providerRepository;
    }
    public function getAllUsers($request)
    {
       
        return $this->userRepository->getAllUsers($request);
    }

    public function getUserById($id)
    {
         return $this->userRepository->getUserById($id);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);

    }

    public function createUser(array $userDetails)
    {
        return $this->userRepository->createUser($userDetails);
    }

    public function updateUser($id, array $newDetails)
    {
       return $this->userRepository->updateUser($id,$newDetails);

    }
    public function importUsers($request)
    {
        foreach($request->all() as $key =>$file){
            if($this->providerRepository->getPrividerByName($key)){
                $provider = $this->providerRepository->getPrividerByName($key);
            $file = $request->file($key);
            $file = fopen($file->getRealPath(), "r");
           
    
            while (!feof($file)) {
                $chunk = fread($file, 1024);
                $users = json_decode($chunk, true);
                //skip record where email not unique
                // $users = array_filter($users, function ($user) {
                //     return User::where('email', $user['email'])->count() == 0;
                // });
                foreach ($users as $user) {
                  $this->userRepository->createUserProvider($user,$provider);
                }
            }
            fclose($file);
            }
        }
    }

}
