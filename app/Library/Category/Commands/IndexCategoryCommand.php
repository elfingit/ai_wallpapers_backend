<?php

namespace App\Library\Category\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Category\Values\IdValue;
use App\Library\Category\Values\TitleValue;
use App\Library\Category\Values\CreatedAtValue;
use App\Library\Category\Values\UpdatedAtValue;
use App\Library\Category\Dto\IndexDto;

class IndexCategoryCommand extends AbstractCommand
{
	public ?IdValue $idValue = null;
	public ?TitleValue $titleValue = null;
	public ?CreatedAtValue $created_atValue = null;
	public ?UpdatedAtValue $updated_atValue = null;

    public static function createFromDto(IndexDto $dto): self
    {
        $command = new self();
		if(!is_null($dto->id)) { 
			$command->idValue = new IdValue($dto->id);
		}
		if(!is_null($dto->title)) { 
			$command->titleValue = new TitleValue($dto->title);
		}
		if(!is_null($dto->created_at)) { 
			$command->created_atValue = new CreatedAtValue($dto->created_at);
		}
		if(!is_null($dto->updated_at)) { 
			$command->updated_atValue = new UpdatedAtValue($dto->updated_at);
		}

        return $command;
    }
}
