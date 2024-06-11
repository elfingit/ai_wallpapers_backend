<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 10.06.24
 * Time: 15:21
 */

namespace App\Library\Category\Handlers;

use App\Library\Category\Commands\GetMainDataCommand;
use App\Library\Category\Results\MainDataResult;
use App\Models\Category;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandHandlerContract;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class GetMainDataHandler implements CommandHandlerContract
{
    /**
     * @param GetMainDataCommand $command
     *
     * @return CommandResultContract|null
     */
    public function __invoke(CommandContract $command): ?CommandResultContract
    {
        $categories = Category::query()
            ->orderByRaw("title->>'{$command->localValue->value()}' ASC")
            ->get();

        $ids = implode(',', $categories->pluck('id')->toArray());

$sql = <<<SQL
select * from (
    select *, row_number() over (PARTITION BY category_id ORDER BY created_at DESC)
    FROM galleries WHERE category_id IN ({$ids}) AND locale = 'en'
              ) g
where row_number <= 3;
SQL;

        $res = \DB::select($sql);
        $data = [];

        foreach ($categories as $category) {

            $pictures = array_filter($res, function ($item) use ($category) {
                return $item->category_id === $category->id;
            });

            $data[] = [
                'id' => $category->id,
                'title' => $category->title,
                'pictures' => array_values($pictures),
            ];
        }

        return new MainDataResult($data);
    }

    public function isAsync(): bool
    {
        return false;
    }
}
