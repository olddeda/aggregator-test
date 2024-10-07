<?php

namespace App\Console\Commands\News;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use App\Modules\News\Interfaces\NewsSourceRepositoryInterface;
use App\Modules\News\Data\NewsSourceData;
use App\Modules\News\Enums\NewsSourceStatus;
use App\Modules\News\Enums\NewsSourceType;

class AddNewsSource extends Command
{
    protected $signature = 'news:source:add';

    /**
     * @var string
     */
    protected $description = 'Add news source';

    /**
     * @param NewsSourceRepositoryInterface $repository
     * @return void
     */
    public function handle(
        NewsSourceRepositoryInterface $repository,
    ): void
    {
        $type = $this->choice(
            'Тип источника',
            NewsSourceType::values(),
            NewsSourceType::RSS->value
        );

        $url = $this->validateCmd(function() {
            return $this->ask('Ссылка на источник', 'https://www.iphones.ru/feed');
        }, ['url', 'required|url|unique:news_sources,url']);

        $repository->create(NewsSourceData::from([
            'type' => NewsSourceType::from($type),
            'status' => NewsSourceStatus::ENABLED,
            'url' => $url,
        ]));

        $this->info('Источник новостей был успешно добавлен');
    }

    /**
     * @param callable $method
     * @param array $rules
     * @return string
     */
    private function validateCmd(callable $method, array $rules): string
    {
        $value = $method();
        $validate = $this->validateInput($rules, $value);

        if ($validate !== true) {
            $this->warn($validate);
            $value = $this->validateCmd($method, $rules);
        }
        return $value;
    }

    /**
     * @param array $rules
     * @param mixed $value
     * @return string|true
     */
    private function validateInput(array $rules, string $value): string|true
    {
        $validator = Validator::make([
            $rules[0] => $value
        ], [
            $rules[0] => $rules[1]
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return $error->first($rules[0]);
        }

        return true;
    }
}
