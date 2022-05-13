<?php

interface Command
{
    public function run();

    public function log();

    public function cancel();
}

class CopyCommand implements Command
{

    public function run()
    {
        echo "Копируем" . PHP_EOL;
    }

    public function log()
    {
        echo "Логируем копирование" . PHP_EOL;
    }

    public function cancel()
    {
        echo "Отмена копирования" . PHP_EOL;
    }
}

class CutCommand implements Command
{

    public function run()
    {
        echo "Вырезаем" . PHP_EOL;
    }

    public function log()
    {
        echo "Логируем вырезание" . PHP_EOL;
    }

    public function cancel()
    {
        echo "Отмена вырезания" . PHP_EOL;
    }
}

class PasteCommand implements Command
{

    public function run()
    {
        echo "Вставляем" . PHP_EOL;
    }

    public function log()
    {
        echo "Логируем вставляние :-)" . PHP_EOL;
    }

    public function cancel()
    {
        echo "Отмена вставляния :-)" . PHP_EOL;
    }
}

class CommandsManager
{

    private array $commands = [
        "copy",
        "cut",
        "paste"
    ];

    public function recieveCommand(string $commandName)
    {
        if (!in_array($commandName, $this->commands)) {
            echo "Неверная команда" . PHP_EOL;
            return false;
        }
        $commandName = strtolower($commandName);
        $commandName = ucfirst($commandName) . "Command";
        $command = new $commandName;
        $command->run();
        return $command;
    }
}

class TextEditor
{
    private CommandsManager $commandManager;
    private string $text;
    private Command $lastCommand;


    public function __construct(string $text)
    {
        $this->text = $text;
        $this->commandManager = new CommandsManager();
    }

    public function applyCommand($commandType, $log = "")
    {
        $command = $this->commandManager->recieveCommand($commandType);
        if (!empty($log)) {
            $command->log();
        }
        if($command){
            $this->lastCommand = $command;
        }
    }

    public function undo()
    {
        if (!empty($this->lastCommand)) {
            $this->lastCommand->cancel();
        }
    }
}

$textEditor = new TextEditor("my text");
$textEditor->applyCommand("copy");
$textEditor->applyCommand("paste");
$textEditor->undo();
$textEditor->applyCommand("cut", "yes");
