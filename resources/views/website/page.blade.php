<x-website.layout.master :title="$page->title . ' - Law-Skoolyst'" :description="$page->meta_description">
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h1 class="mb-4">{{ $page->title }}</h1>
                <div class="page-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</x-website.layout.master>
