<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;

class UserRepository
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function getAllUsers($request)
    {
        $query = $this->user->query();

    if ($request->has('provider')) {
        $query->where('provider', $request->input('provider'));
    }
    if ($request->has('statusCode')) {
        $query->where('status', $request->input('status'));
    }
    if ($request->has('currency')) {
        $query->where('currency', $request->input('currency'));
    }
    if ($request->has('identification')) {
        $query->where('identification', $request->input('identification'));
    }
    if ($request->has('balanceMin') && $request->has('balanceMax')) {
        $query->whereBetween('balance', [$request->input('min_balance'), $request->input('max_balance')]);
    }
    if ($request->has('balance')) {
        $query->where('balance', $request->input('balance'));
    }
    if ($request->has('email')) {
        $query->where('email', $request->input('email'));
    }
    if ($request->has('created_at')) {
        $query->where('created_at', $request->input('created_at'));
    }
    return $query->paginate();

       
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function deleteUser($id){
        return User::destroy($id);
    }

    public function createUser(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function updateUser($id, array $newDetails)
    {
           $user =  User::where('id',$id)->first();
           $user->update($newDetails);
           return $user;
    }
    public function createUserProvider(array $user, $provider)
    {
        $user = User::updateOrCreate(['identification' => $user[$provider['identification']]],[
            'email' => $user[$provider['email']],
            'balance' => $user[$provider['balance']],
            'status' => $user[$provider['status']] == $provider['authorised'] ? "authorised" : ($user[$provider['status']] == $provider['declined'] ? "decline" : "refunded"),
            'currency' => $user[$provider['currency']],
            'provider' => $provider['name'],
            'created_at' =>  Carbon::createFromFormat($provider['created_at_format'], $user[$provider['created_at']])->format("Y-m-d"),
        ]);
        return $user;
    }
}
