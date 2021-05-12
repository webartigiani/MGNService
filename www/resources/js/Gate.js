export default class Gate{

    constructor(user){
        this.user = user;
    }
    isAdmin(){
        return this.user.type === 'admin';
    }
    isWebMaster(){
        return this.user.type === 'webmaster';
    }
    isAdminOrWebMaster(){
        if(this.user.type === 'admin' || this.user.type === 'webmaster'){
            return true;
        }
    }
    isUser(){
        return this.user.type === 'user';
    }
    isAdminOrUser(){
        if(this.user.type === 'user' || this.user.type === 'admin' || this.user.type === 'webmaster'){
            return true;
        }
    }
}

