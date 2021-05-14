import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { LoginVeichlePageRoutingModule } from './login-veichle-routing.module';

import { LoginVeichlePage } from './login-veichle.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    LoginVeichlePageRoutingModule
  ],
  declarations: [LoginVeichlePage]
})
export class LoginVeichlePageModule {}
