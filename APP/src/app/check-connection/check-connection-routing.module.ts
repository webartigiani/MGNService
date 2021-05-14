import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CheckConnectionPage } from './check-connection.page';

const routes: Routes = [
  {
    path: '',
    component: CheckConnectionPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CheckConnectionPageRoutingModule {}
