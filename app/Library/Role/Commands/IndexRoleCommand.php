<?php

namespace App\Library\Role\Commands;

use Elfin\LaravelCommandBus\Library\AbstractCommand;

use App\Library\Role\Values\IdValue;
use App\Library\Role\Values\TitleValue;
use App\Library\Role\Values\CreatedAtValue;
use App\Library\Role\Values\UpdatedAtValue;
use App\Library\Role\Dto\IndexDto;

class IndexRoleCommand extends AbstractCommand
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
