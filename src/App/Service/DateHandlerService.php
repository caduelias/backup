<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\DateHandlerException;
use DateTime;
use Exception;

class DateHandlerService
{ 
    /**
     * Formata a data em d/m/Y
     * @param string $date
     * @param string $format
     * @return false|string
     * @throws DateHandlerException
     */
    public function formatDate(string $date, string $format = "d/m/Y"): string
    {
        try {
            $dateFormat = date($format, strtotime($date));
            if (!is_string($dateFormat)) {
                throw new DateHandlerException("Ocorreu um erro a converter a data!", 500);
            }
            return $dateFormat;
        } catch (Exception $e) {
            throw new DateHandlerException("Ocorreu um erro a converter a data!", 500);
        }
    }

    /**
     * Verifica se é um formato de data válido
     * @param string $date
     * @param string $format
     * @return bool
     */
    public function isValidDate(string $date, string $format = "Y-m-d"): bool
    {
        if (empty($date)) {
            return false;
        }
        $dateFormat = DateTime::createFromFormat($format, $date);
        return $dateFormat && $dateFormat->format($format) == $date;
    }

    /**
     * Converte string em datetime
     * @param string $date
     * @param string $format
     * @return DateTime
     * @throws DateHandlerException
     */
    public function formatToDateTime(string $date, string $format = "d/m/Y H:i:s"): DateTime
    {
        try {
            return DateTime::createFromFormat($format, $date);
        } catch (Exception $e) {
            throw new DateHandlerException("Ocorreu um erro a converter a data!", 500);
        }
    }

    /**
     * Retorna uma matriz de strings, cada uma como substring de string divididas por $delimiter
     * @param string $delimiter
     * @param string $date
     * @return array
     */
    public function separateDate(string $delimiter, string $date): array
    {
        return explode($delimiter, $date);
    }

    /**
     * Adiciona mês a data do parâmetro
     * @param int $i
     * @param $day
     * @param $month
     * @param $year
     * @return string
     */
    public function addMonth(int $i, $day, $month, $year): string
    {
        return date("Y-m-d", strtotime("+" . $i . " month", mktime(
            0,
            0,
            0,
            intval($month),
            intval($day),
            intval($year)
        )));
    }

    /**
     * Retorna em string o último dia do último mês
     * @return string
     */
    public function getLastDayOfLastMonth(): string
    {
        $month_start = strtotime('last day of last month', time());
        return date('Y/m/d', $month_start);
    }

    /**
     * Retorna em string o primeiro dia do último mês
     * @return string
     */
    public function getFirstDayOfLastMonth(): string
    {
        $month_end = strtotime('first day of last month', time());
        return date('Y/m/d', $month_end);
    }

    /**
     * Retorna a data de hoje
     * @return string
     */
    public function dateNow(): string
    {
        return date('d-m-Y');
    }

    /**
     * Retorna a data e hora de hoje
     * @return string
     */
    public function dateTimeNow(): string
    {
        return date('d-m-Y H:i:s');
    }

    /**
     * Retorna a data de hoje
     * @return string
     */
    public function dateNowFormat(): string
    {
        return date('d-m-Y');
    }

    /**
     * Retorna a data de hoje + dia inserido
     * @param int $days
     * @return string
     */
    public function addDay(int $days): string
    {
        return date('d-m-Y', strtotime('+' . $days . ' days', strtotime($this->dateNowFormat())));
    }

    /**
     * Retorna a data/hora de hoje + dia inserido
     * @param int $days
     * @return string
     */
    public function addDayTime(int $days): string
    {
        return date('d-m-Y H:i:s', strtotime('+1 days'));
    }


    /**
     * Retorna a data por extenso
     * @param string $date
     * Exemplo:
     * A = dia
     * B = mês
     * Y = ano
     * @return string
     */
    public function getDatePerExtensive(string $date): string
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return strftime('%' . $date, strtotime('today'));
    }

    /**
     * Define o timezone
     */
    public function setTimeZone(): void
    {
        date_default_timezone_set('America/Sao_Paulo');
    }
}