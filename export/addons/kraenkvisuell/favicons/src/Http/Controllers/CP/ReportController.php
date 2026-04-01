<?php

namespace Kraenkvisuell\Favicons\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Statamic\CP\Column;
use Statamic\Exceptions\NotFoundHttpException;
use Statamic\Facades\User;
use Statamic\Http\Controllers\CP\CpController;
use Kraenkvisuell\Favicons\Http\Resources\Reporting\Report as ReportResource;
use Kraenkvisuell\Favicons\Reporting\Report;

class ReportController extends CpController
{
    public function index(Request $request)
    {
        $this->authorize('view favicons reports');

        $reports = Report::all();

        $columns = [
            Column::make('site_score')
                ->label(__('favicons::messages.site_score'))
                ->sortable(false),
            Column::make('generated')
                ->label(__('favicons::messages.generated'))
                ->sortable(false),
            Column::make('actionable_pages')
                ->label(__('favicons::messages.actionable_pages'))
                ->sortable(false),
            Column::make('total_pages_crawled')
                ->label(__('favicons::messages.total_pages_crawled'))
                ->sortable(false),
        ];

        if ($request->wantsJson()) {
            $perPage = $request->get('perPage');
            $currentPage = $request->get('page', 1);

            $paginated = new LengthAwarePaginator(
                items: $reports->forPage($currentPage, $perPage),
                total: $reports->count(),
                perPage: $perPage,
                currentPage: $currentPage,
            );

            return ReportResource::collection($paginated)->additional([
                'meta' => ['columns' => $columns],
            ]);
        }

        if ($reports->isEmpty()) {
            return Inertia::render('favicons::Reports/Empty', [
                'createUrl' => cp_route('favicons.reports.create'),
            ]);
        }

        return Inertia::render('favicons::Reports/Index', [
            'columns' => $columns,
            'listingUrl' => cp_route('favicons.reports.index'),
            'createUrl' => cp_route('favicons.reports.create'),
            'canDelete' => User::current()->can('delete favicons reports'),
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('view favicons reports');

        $report = Report::create()->save();

        return redirect()->cpRoute('favicons.reports.show', $report->id());
    }

    public function show(Request $request, $id)
    {
        $this->authorize('view favicons reports');

        throw_unless($report = Report::find($id), NotFoundHttpException::class);

        $report->generateIfNecessary();

        if ($request->wantsJson()) {
            return $report->data();
        }

        return Inertia::render('favicons::Reports/Show', [
            'report' => $report,
            'createReportUrl' => cp_route('favicons.reports.create'),
            'pagesUrl' => cp_route('favicons.reports.pages.index', $report->id()),
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete favicons reports');

        return Report::find($id)->delete();
    }
}
