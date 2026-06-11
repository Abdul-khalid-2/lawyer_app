{{-- Renders a responsive grid of lawyer cards. Used by the listing page
     and by WebsiteLawyersController@loadMore (so AJAX-appended cards match). --}}
@forelse($lawyers as $lawyer)
    <x-website.cards.lawyer-card :lawyer="$lawyer" />
@empty
    @if(!($hideEmptyMessage ?? false))
        <div class="col-12">
            <x-website.sections.empty-state icon="fas fa-search"
                title="No lawyers found"
                message="Try adjusting your search criteria or filters" />
        </div>
    @endif
@endforelse
