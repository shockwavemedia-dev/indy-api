<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\TicketNoteRepository;
use App\Services\TicketNotes\Resources\UpdateTicketNoteResource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;

/**
 * @covers \App\Repositories\TicketNoteRepository
 */
final class TicketNoteRepositoryTest extends TestCase
{
    public function testFindAllTicketNotes(): void
    {
        $ticket = $this->env->ticket()->ticket;

        $ticketNote = $this->env->ticketNote(
            [
                'ticket_id' => $ticket->getId()
            ]
        )->ticketNote;

        $repository = new TicketNoteRepository();

        $findAllTicketNotes = $repository->findAllTicketNotes($ticket);

        /** @var \App\Models\Tickets\TicketNote $actual */
        $actual = $findAllTicketNotes->find($ticketNote->getId());

        $this->assertEquals($ticket->getId(), $ticketNote->getTicketId());

        $this->assertNotNull($actual);

        $this->assertArrayHasKeys(
            [
                'ticket_id',
                'note',
                'created_by',
                'created_at'
            ],
            $actual->toArray()
        );
    }

    /**
     * @throws UnknownProperties
     */
    public function testUpdateTicketNote(): void
    {

        $ticketNote = $this->env->ticketNote()->ticketNote;

        $user = $this->env->user()->user;

        $updateResource = new UpdateTicketNoteResource([
            'updatedBy' => $user,
            'note' => "{\"blocks\": [{\"key\": \"1thpk\", \"data\": {}, \"text\": \"plain\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"b5eld\", \"data\": {}, \"text\": \"italic\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"ITALIC\", \"length\": 6, \"offset\": 0}]}, {\"key\": \"cg18l\", \"data\": {}, \"text\": \"bold\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"BOLD\", \"length\": 4, \"offset\": 0}]}, {\"key\": \"46l2k\", \"data\": {}, \"text\": \"underline\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"UNDERLINE\", \"length\": 9, \"offset\": 0}]}, {\"key\": \"612bt\", \"data\": {}, \"text\": \"strikethrough\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"STRIKETHROUGH\", \"length\": 13, \"offset\": 0}]}, {\"key\": \"95ul\", \"data\": {}, \"text\": \"depth1\", \"type\": \"unordered-list-item\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"6m28o\", \"data\": {}, \"text\": \"depth2\", \"type\": \"unordered-list-item\", \"depth\": 1, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"eeh31\", \"data\": {}, \"text\": \"depth3\", \"type\": \"unordered-list-item\", \"depth\": 2, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"9lim6\", \"data\": {}, \"text\": \"depth4\", \"type\": \"unordered-list-item\", \"depth\": 3, \"entityRanges\": [], \"inlineStyleRanges\": []}], \"entityMap\": {}}",
        ]);

        $repository = new TicketNoteRepository();

        $expected = [
            'updated_by' => $user->getId(),
            'note' => "{\"blocks\": [{\"key\": \"1thpk\", \"data\": {}, \"text\": \"plain\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"b5eld\", \"data\": {}, \"text\": \"italic\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"ITALIC\", \"length\": 6, \"offset\": 0}]}, {\"key\": \"cg18l\", \"data\": {}, \"text\": \"bold\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"BOLD\", \"length\": 4, \"offset\": 0}]}, {\"key\": \"46l2k\", \"data\": {}, \"text\": \"underline\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"UNDERLINE\", \"length\": 9, \"offset\": 0}]}, {\"key\": \"612bt\", \"data\": {}, \"text\": \"strikethrough\", \"type\": \"unstyled\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": [{\"style\": \"STRIKETHROUGH\", \"length\": 13, \"offset\": 0}]}, {\"key\": \"95ul\", \"data\": {}, \"text\": \"depth1\", \"type\": \"unordered-list-item\", \"depth\": 0, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"6m28o\", \"data\": {}, \"text\": \"depth2\", \"type\": \"unordered-list-item\", \"depth\": 1, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"eeh31\", \"data\": {}, \"text\": \"depth3\", \"type\": \"unordered-list-item\", \"depth\": 2, \"entityRanges\": [], \"inlineStyleRanges\": []}, {\"key\": \"9lim6\", \"data\": {}, \"text\": \"depth4\", \"type\": \"unordered-list-item\", \"depth\": 3, \"entityRanges\": [], \"inlineStyleRanges\": []}], \"entityMap\": {}}",
        ];

        $ticketNote = $repository->updateTicketNote($ticketNote, $updateResource);

        $ticketNote->refresh();

        $actual = [
            'note' => $ticketNote->getNote(),
            'updated_by' => $ticketNote->getUpdatedById(),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testDeleteTicketNote(): void
    {
        $ticketNote = $this->env->ticketNote()->ticketNote;

        $user = $this->env->user()->user;

        $repository = new TicketNoteRepository();

        $repository->deleteTicketNote($ticketNote,$user);

        $ticketNote->refresh();

        $this->assertNotNull($ticketNote->getDeletedAt());
    }

}
