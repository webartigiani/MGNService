import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CheckConnectionPageRoutingModule } from './check-connection-routing.module';

import { CheckConnectionPage } from './check-connection.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CheckConnectionPageRoutingModule
  ],
  declarations: [CheckConnectionPage]
})
export class CheckConnectionPageModule {}
