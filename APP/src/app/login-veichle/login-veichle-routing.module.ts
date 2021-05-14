import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LoginVeichlePage } from './login-veichle.page';

const routes: Routes = [
  {
    path: '',
    component: LoginVeichlePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class LoginVeichlePageRoutingModule {}
