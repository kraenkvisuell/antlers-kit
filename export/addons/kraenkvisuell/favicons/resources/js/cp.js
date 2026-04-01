import Index from './pages/Index.vue'
import SectionDefaultsIndex from './pages/section-defaults/Index.vue'
import SiteDefaultsEdit from './pages/site-defaults/Edit.vue'
import FaviconsFieldtype from './components/fieldtypes/FaviconsFieldtype.vue'
import SourceFieldtype from './components/fieldtypes/SourceFieldtype.vue'

Statamic.booting(() => {
    Statamic.$inertia.register('favicons::Index', Index)
    Statamic.$inertia.register('favicons::SectionDefaults/Index', SectionDefaultsIndex)
    Statamic.$inertia.register('favicons::SiteDefaults/Edit', SiteDefaultsEdit)

    Statamic.$components.register('favicons-fieldtype', FaviconsFieldtype)
    Statamic.$components.register('favicons_source-fieldtype', SourceFieldtype)
})
