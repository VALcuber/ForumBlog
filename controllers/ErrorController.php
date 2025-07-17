<?php
/** @used-by Router */
class ErrorController extends Controller{

    private $pageTpl = '/templates/error.tpl';

    public function __construct() {
        parent::__construct();
        $this->view = new View();
    }

    public function index(string $title = 'Error', string $message = 'An unexpected error occurred.') {

        $this->controller();

        $this->pageData['titleEscaped'] = $title;
        $this->pageData['messageEscaped'] = $message;

        $this->view->render($this->pageTpl, $this->pageData);
    }

    /**
     * Handle PDOException and return user-friendly message.
     */
    public function handlePdoException(PDOException $e): string {
        $sqlstate = $e->getCode();
        $errorInfo = $e->errorInfo ?? [];
        $mysqlCode = $errorInfo[1] ?? null;

        $sqlstateMessages = [
            '01000' => 'General warning.',
            '01001' => 'Cursor operation conflict.',
            '01002' => 'Disconnect error.',
            '01003' => 'Null value eliminated in set function.',
            '01004' => 'String data right truncation.',
            '01005' => 'Insufficient descriptor areas.',
            '01006' => 'Privilege not revoked.',
            '01007' => 'Privilege not granted.',
            '01008' => 'Implicit zero-bit padding.',
            '02000' => 'No data found (e.g., no rows).',
            '07000' => 'Dynamic SQL error.',
            '07001' => 'Using clause does not match parameter specs.',
            '07002' => 'Wrong number of input/output parameters.',
            '07003' => 'Cursor specification cannot be executed.',
            '08000' => 'Connection exception.',
            '08001' => 'Client unable to establish connection.',
            '08002' => 'Connection name in use.',
            '08003' => 'Connection does not exist.',
            '08004' => 'Server rejected the connection.',
            '08006' => 'Connection failure.',
            '08007' => 'Transaction resolution unknown.',
            '0A000' => 'Feature not supported.',
            '0B000' => 'Invalid transaction initiation.',
            '20000' => 'Case not found for CASE statement.',
            '21000' => 'Cardinality violation.',
            '21S01' => 'Insert value list does not match column list.',
            '22000' => 'Data exception.',
            '22001' => 'String data right truncation.',
            '22002' => 'Null value not allowed.',
            '22003' => 'Numeric value out of range.',
            '22007' => 'Invalid datetime format.',
            '22012' => 'Division by zero.',
            '22025' => 'Invalid escape sequence.',
            '23000' => 'Integrity constraint violation (e.g., foreign key, duplicate entry).',
            '25000' => 'Invalid transaction state.',
            '27000' => 'Triggered data change violation.',
            '28000' => 'Invalid authorization specification (invalid username/password).',
            '2A000' => 'Direct SQL syntax error or access rule violation.',
            '2B000' => 'Dependent privilege descriptors still exist.',
            '2C000' => 'Invalid character set name.',
            '2D000' => 'Invalid transaction termination.',
            '2E000' => 'Invalid connection name.',
            '33000' => 'Invalid SQL descriptor name.',
            '34000' => 'Invalid cursor name.',
            '3D000' => 'Invalid catalog name.',
            '3F000' => 'Invalid schema name.',
            '40000' => 'Transaction rollback.',
            '40001' => 'Serialization failure.',
            '40002' => 'Integrity constraint violation during transaction.',
            '40003' => 'Statement completion unknown.',
            '40005' => 'Statement aborted — unique violation.',
            '40010' => 'Statement aborted — previously aborted.',
            '42000' => 'Syntax error or access rule violation.',
        ];

        $mysqlCodeMessages = [
            1045 => 'Access denied: invalid username or password.',
            1049 => 'Unknown database name.',
            2002 => 'Cannot connect: database server is unreachable or not running.',
            2003 => 'Cannot connect: connection refused or timed out.',
            2005 => 'Unknown MySQL server host.',
            2006 => 'MySQL server has gone away.',
        ];

        if ($mysqlCode && isset($mysqlCodeMessages[$mysqlCode])) {
            return $mysqlCodeMessages[$mysqlCode];
        } elseif (isset($sqlstateMessages[$sqlstate])) {
            return $sqlstateMessages[$sqlstate];
        } else {
            return 'Database error occurred.';
        }
    }

    /**
     * Handle general Exception and return user-friendly message.
     */
    public function handleGeneralException(Exception $e): string {
        $code = $e->getCode();

        $exceptionCodeMessages = [
            // Internal app-specific/general errors (not HTTP)
            1     => 'Unknown error.',                 // Unknown error occurred
            2     => 'Runtime error.',                 // General runtime error
            3     => 'Invalid argument.',              // Invalid function argument
            4     => 'Out of range.',                  // Value out of valid range
            5     => 'Logic error.',                   // Logic error in application code
            100   => 'Application specific error.',   // Custom app-specific error

            // HTTP client errors (4xx)
            400   => 'Bad request.',                   // Request syntax invalid
            401   => 'Unauthorized.',                  // Authentication required
            402   => 'Payment required.',              // Reserved for future use
            403   => 'Forbidden.',                     // Authenticated but no permission
            404   => 'Page not found.',                // Resource not found
            405   => 'Method not allowed.',            // HTTP method not supported
            406   => 'Not acceptable.',                // Content negotiation failed
            407   => 'Proxy authentication required.',// Proxy authentication required
            408   => 'Request timeout.',               // Request timed out
            409   => 'Conflict.',                      // Conflict with current state
            410   => 'Gone.',                          // Resource permanently removed
            411   => 'Length required.',               // Content-Length required
            412   => 'Precondition failed.',           // Preconditions given in headers failed
            413   => 'Payload too large.',             // Request entity too large
            414   => 'URI too long.',                  // Request URI too long
            415   => 'Unsupported media type.',        // Media type unsupported
            416   => 'Range not satisfiable.',          // Requested range not available
            417   => 'Expectation failed.',             // Expectation header failed
            426   => 'Upgrade required.',               // Client must switch protocols
            428   => 'Precondition required.',          // Precondition required for request
            429   => 'Too many requests.',               // Rate limiting
            431   => 'Request header fields too large.',// Headers too large
            451   => 'Unavailable for legal reasons.',  // Blocked for legal reasons

            // HTTP server errors (5xx)
            500   => 'Internal server error.',         // Generic server error
            501   => 'Not implemented.',                // Feature not implemented
            502   => 'Bad gateway.',                    // Invalid response from upstream server
            503   => 'Service unavailable.',            // Server overloaded or down
            504   => 'Gateway timeout.',                // Timeout from upstream server
            505   => 'HTTP version not supported.',     // Unsupported HTTP version
            506   => 'Variant also negotiates.',         // Transparent content negotiation error
            507   => 'Insufficient storage.',            // Server storage full
            508   => 'Loop detected.',                    // Infinite loop detected
            510   => 'Not extended.',                     // Further extensions required
            511   => 'Network authentication required.',// Network authentication needed
        ];

        if ($code && isset($exceptionCodeMessages[$code])) {
            return $exceptionCodeMessages[$code];
        }

        return $e->getMessage() ?: 'Unexpected error occurred.';
    }

    public function showErrorPage(string $title, string $message) {
        $titleEscaped = htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $messageEscaped = nl2br(htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    }

}