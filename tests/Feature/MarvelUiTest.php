<?php

it('has marvelui page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
