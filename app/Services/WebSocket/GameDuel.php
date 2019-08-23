<?php
/**
*   1. Сгененрировать уникальный номер и игры для двух игроков
 *  2. Запись в БД при каждом ходе в игре
 *  3. Триггер конца игры и таймер отсчёта
 *  4. При каждом ходе происходит запись в БД и также сверка данный об игре, на движение в следующий шаг
 */
namespace App\Services\WebSocket;
use App\Models\TaskMath;
use Ratchet\ConnectionInterface;
use App\Models\Game_Duel;
class GameDuel extends RatchetInterface
{
    protected $clients;
    /**
     * Общий список пользователей с открытым соединением
     */
    private $users;
    /**
     * Общий список игроков
     */
    private $players;
    /**
     * Игроки соединённые в одну игру
     */
    private $found_players;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    //Открытие соединения для каждого пользователя
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        //dd($conn);
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
    }

    //Реализуется отправка сообщения каждому пользователю в сети
    /**
     * @param ConnectionInterface $from
     * @param $msg
     */
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $msg = json_decode($msg);

        //Приходит объект с ярлыком find, ищем участника в массиве players, отбираемый первым из списка.
        switch ($msg->action){
            case 'find':
                //Создаём нового участника игры - записываем приходящий объект в массив
                $this->players[$from->resourceId] = $msg;

                    if(count($this->players) > 1){
                        //Game_Duel::genIdUniqueGames();
                        $this->found_players = $this->choosePlayersForGameDuel($this->players, 2);

                        //dd($this->players);
                        $tasks = TaskMath::select('id', 'number_task', 'grade', 'task', 'answer', 'detail')->where('grade', 'D')->get();
                        $task = array_rand($tasks);
                        if(!empty($this->found_players[0]) && !empty($this->found_players[1])){
                            $this->users[$from->resourceId]->send('От кого:'. $this->found_players[0]->id.'. Кому - первому в списке: '. $this->found_players[1]->id.'. По времени '. date('m:s', $msg->date));
                            $this->users[$this->found_players[0]->resourceId]->send('Текст задачи');
                            $this->users[$this->found_players[1]->resourceId]->send('Текст задачи');
                        }
                    }else
                        $this->users[$from->resourceId]->send('Игрок не найден попробуйте ещё раз! '.json_encode($msg));
                break;
            case 'end':
                $this->users[$from->resourceId]->send('Итоги игры');
                break;
            case 'message':
                if ($from->resourceId == $this->found_players[0]->resourceId){
                    $this->users[$this->found_players[0]->resourceId]->send('Вы ответили правильно'.$msg->msg);
                    $this->users[$this->found_players[1]->resourceId]->send('Ваш соперник ответили правильно');
                }
                else if ($from->resourceId == $this->found_players[1]->resourceId)
                    $this->users[$this->found_players[1]->resourceId]->send($msg->msg);
        }
    }
    /**
     * Функция отбирает первых двух участников игры, убирает их из основного массива и возвращает массив двух объектов
     * Создается объект со свойствами игрока
     * @param $array_players
     * @param  $count
     * @return array
     */
    public function choosePlayersForGameDuel($array_players, $count){
        $i = 0;
        $found_players = [];

        foreach ($array_players as $resId => $player) {

            if($i < $count){
                $players = new \stdClass;
                $players->resourceId = $resId;
                $players->id = $player->id;
                $players->date = $player->date;
                $players->game_number = 0;
                $i++;
                array_push($found_players, $players);
                unset($this->players[$resId]);//Удаляем из основного массива ожидающего игрока
            }else
                break;
        }
        return $found_players;
    }

    //Закрытие соединения для каждого пользователя
    public function onClose(ConnectionInterface $conn) {

        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->players[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    //Вывод ошибки
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}