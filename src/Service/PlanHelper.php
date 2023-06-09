<?php

    namespace App\Service;

    use App\Form\Type\PlanType;
    use App\Repository\PlanUsersRepository;
    use App\Repository\PlanRepository;
    use App\Entity\PlanUsers;
    use App\Entity\Plan;

    class PlanHelper
    {   
        public $planRepository = null;
        public $planUsersRepository = null;

        public function __construct(PlanUsersRepository $planUsersRepository, PlanRepository $planRepository)
        {
            $this->planUsersRepository = $planUsersRepository;
            $this->planRepository = $planRepository;
        }

        /**
         * checkPlanExist() method to check whether plan exist in database
         * 
         * @param int $plan_id plan id
         * 
         * @return string|bool
         */
        public function checkPlanExist(int $plan_id): string|bool
        {   
            // find plan by id
            $plan = $this->planRepository->find($plan_id);
            // check if $plan is empty
            if(!$plan) {
                // if is return message
                $message = "Plan not find with id ".$plan_id;
                return $message;
            }

            return True;
        }

        /**
         * checkUserExist() method to check whether user exist in database
         * 
         * @param int $user_id user id
         * 
         * @return string|bool
         */
        public function checkUserExist(int $user_id): string|bool
        {
            // find user by id
            $user = $this->planUsersRepository->findUser($user_id);
            // check if $user is empty
            if(!$user) {
                // if is return message
                $message = "User not find with id ".$user_id;
                return $message;
            }

            return True;
        }

        /**
         * checkUserExistInPlan() method to check whether user exist in plan
         * 
         * @param int $plan_id plan id
         * @param int $user_id user id
         * 
         * @return string|array
         */
        public function checkUserExistInPlan(int $plan_id, int $user_id): string|array
        {
            // find user by id
            $user = $this->planUsersRepository->findUserInPlan($plan_id, $user_id);
            // check if $user is empty
            if(!$user) {
                // if is return message
                $message = "User not find with id ".$user_id." in plan with id ".$plan_id;
                return $message;
            }

            return $user;
        }

        /**
         * addUserIntoPlan() method to add new user into plan
         * 
         * @param class $entityManager set of methods for Entity
         * @param int $user_id id of user
         * @param int $plan_id id of plan
         * 
         * @return object
         */
        public function addUserIntoPlan($entityManager, int $user_id, int $plan_id): object
        {
            // create object from PlanUsers Entity
            $planUsers = new PlanUsers();
            // set values to variables
            $planUsers->setPlanId($plan_id);
            $planUsers->setUserId($user_id);

            // tell Doctrine to save PlanUsers
            $entityManager->persist($planUsers);
            // run INSERT method
            $entityManager->flush();

            return $planUsers;
        }
    }


?>