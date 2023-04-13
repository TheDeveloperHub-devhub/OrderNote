<?php declare(strict_types=1);

namespace DeveloperHub\OrderNote\Api\Data;

interface OrderNoteInterface
{
    const ORDER_NOTE = 'developerhub_order_note';

    /** @return string|null */
    public function getNote(): ?string;

    /**
     * @param string $note
     * @return mixed
     */
    public function setNote(string $note);
}
