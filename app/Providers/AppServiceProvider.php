<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use App;
use App\Repositories\Survey\SurveyInterface;
use App\Repositories\Question\QuestionInterface;
use App\Repositories\Answer\AnswerInterface;
use App\Repositories\Survey\SurveyRepository;
use App\Repositories\Question\QuestionRepository;
use App\Repositories\Answer\AnswerRepository;
use App\Repositories\Result\ResultInterface;
use App\Repositories\Result\ResultRepository;
use App\Repositories\Invite\InviteInterface;
use App\Repositories\Invite\InviteRepository;
use App\Repositories\Setting\SettingInterface;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Section\SectionInterface;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Feedback\FeedbackInterface;
use App\Repositories\Feedback\FeedbackRepository;
use App\Repositories\Media\MediaInterface;
use App\Repositories\Media\MediaRepository;
use Blade;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Session::put('locale', 'vn');
        Blade::directive('switch', function($condition){
            return "<?php switch({$condition}){ ";
        });
        Blade::directive('firstcase', function($value){
            return "case {$value}:  ?>";
        });
        Blade::directive('case', function($value){
            return "<?php  case {$value}:  ?>";
        });
        Blade::directive('break', function(){
            return "<?php break; ?>";
        });
        Blade::directive('default', function(){
            return "<?php default : ?>";
        });
        Blade::directive('endswitch', function(){
            return "<?php }  ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(UserInterface::class, UserRepository::class);
        App::bind(SurveyInterface::class, SurveyRepository::class);
        App::bind(AnswerInterface::class, AnswerRepository::class);
        App::bind(QuestionInterface::class, QuestionRepository::class);
        App::bind(ResultInterface::class, ResultRepository::class);
        App::bind(InviteInterface::class, InviteRepository::class);
        App::bind(SettingInterface::class, SettingRepository::class);
        App::bind(FeedbackInterface::class, FeedbackRepository::class);
        App::bind(SectionInterface::class, SectionRepository::class);
        App::bind(MediaInterface::class, MediaRepository::class);
    }
}
