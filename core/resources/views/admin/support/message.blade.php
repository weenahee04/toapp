@if ($message->admin_id == 0)
<div id="reply_{{$message->id}}" class="row border border--primary border-radius-3 my-3 mx-0">

    <div class="col-md-3 border-end text-md-end text-start">
        <h5 class="my-3">{{ $ticket->name }}</h5>
        @if ($ticket->user_id != null)
            <p><a href="{{ route('admin.users.detail', $ticket->user_id) }}">&#64;{{ $ticket->name }}</a></p>
        @else
            <p>@<span>{{ $ticket->name }}</span></p>
        @endif
        <button class="btn btn--danger btn-sm my-3 confirmationBtn delete-reply" data-question="@lang('Are you sure to delete this message?')" data-action="{{ route('admin.ticket.delete', $message->id) }}"><i class="la la-trash"></i> @lang('Delete')</button>
    </div>

    <div class="col-md-9">
        <p class="text-muted fw-bold my-3">
            @lang('Posted on') {{ showDateTime($message->created_at, 'l, dS F Y @ h:i a') }}</p>
        <p>{{ $message->message }}</p>
        @if ($message->attachments->count() > 0)
            <div class="my-3">
                @foreach ($message->attachments as $k => $image)
                    <a href="{{ route('admin.ticket.download', encrypt($image->id)) }}" class="me-2"><i class="fa-regular fa-file"></i> @lang('Attachment') {{ ++$k }}</a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@else
<div id="reply_{{$message->id}}" class="row border border-warning border-radius-3 my-3 mx-0 admin-bg-reply">

    <div class="col-md-3 border-end text-md-end text-start">
        <h5 class="my-3">{{ @$message->admin->name }}</h5>
        <p class="lead text-muted">@lang('Staff')</p>
        <button class="btn btn--danger btn-sm my-3 confirmationBtn delete-reply" data-question="@lang('Are you sure to delete this message?')" data-action="{{ route('admin.ticket.delete', $message->id) }}"><i class="la la-trash"></i> @lang('Delete')</button>
    </div>

    <div class="col-md-9">
        <p class="text-muted fw-bold my-3">
            @lang('Posted on') {{ showDateTime($message->created_at, 'l, dS F Y @ h:i a') }}</p>
        <p>{{ $message->message }}</p>
        @if ($message->attachments->count() > 0)
            <div class="my-3">
                @foreach ($message->attachments as $k => $image)
                    <a href="{{ route('admin.ticket.download', encrypt($image->id)) }}" class="me-2"><i class="fa-regular fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endif