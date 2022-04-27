# iphone-photography-achievements
Our customers access their purchased courses via our Course Portal.  
As part of this experience users are able to unlock achievements and earn batches.

Built with Laravel

Worked on all features specified :

- Unlocking Achievements (listens for user events and unlocks the relevant achievement).
- Unlocking Badges (listens for when a user unlocks enough achievement to earn a new badge).
- Achievements Endpoint 
  - (returns unlocked_achievements, next_available_achievements, current_badge, next_badge, remaining_to_unlock_next_badge).
- cached response to optimize application and reduce load time.

### HOW TO INSTALL

- Clone project to your local repository.

- copy env example file to .env to match your local setup

- RUN the following commands

- `composer install`

- `php artisan migrate`

- `php artisan db:seed`

- run test using ` composer test` or `./vendor/bin/phpunit`

 you are all set!!!
