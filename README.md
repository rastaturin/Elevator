#Elevator#

This is the test application which emulates working of elevators.

You can try it here: [http://elevator.mobi22.com/view.php](http://elevator.mobi22.com/view.php)

API endpoint: [http://elevator.mobi22.com/index.php](http://elevator.mobi22.com/index.php)

It requires input of requests in the following format: 


    [
        {
            "from": 6,
            "to": 1
        },
        {
            "from": 5,
            "to": 7
        },
        {
            "from": 3,
            "to": 1
        },
        {
            "from": 1,
            "to": 7
        }
    ]

and returns list of the elevator's states for each steps.
 
 
 
